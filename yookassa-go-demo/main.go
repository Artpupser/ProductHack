package main

import (
	"bufio"
	"bytes"
	"encoding/base64"
	"encoding/json"
	"log"
	"net/http"
	"os"
	"strings"
	"time"

	"github.com/google/uuid"
)

type PaymentRequest struct {
	Amount struct {
		Value    string `json:"value"`
		Currency string `json:"currency"`
	} `json:"amount"`
	Confirmation struct {
		Type      string `json:"type"`
		ReturnURL string `json:"return_url,omitempty"`
	} `json:"confirmation"`
	Capture     bool   `json:"capture"`
	Description string `json:"description"`
}

type PaymentResponse struct {
	Confirmation struct {
		ConfirmationToken string `json:"confirmation_token"`
	} `json:"confirmation"`
}

func loadEnv(path string) error {
	file, err := os.Open(path)
	if err != nil {
		return err
	}
	defer file.Close()

	scanner := bufio.NewScanner(file)
	for scanner.Scan() {
		line := scanner.Text()
		line = strings.TrimSpace(line)
		if line == "" || strings.HasPrefix(line, "#") {
			continue
		}
		parts := strings.SplitN(line, "=", 2)
		if len(parts) != 2 {
			continue
		}
		key := strings.TrimSpace(parts[0])
		val := strings.TrimSpace(parts[1])
		os.Setenv(key, val)
	}
	return scanner.Err()
}

func createPayment(shopID, secretKey string) (string, error) {
	url := "https://api.yookassa.ru/v3/payments"

	reqData := PaymentRequest{}
	reqData.Amount.Value = "100.00"
	reqData.Amount.Currency = "RUB"
	reqData.Capture = true
	reqData.Description = "Оплата с сайта"
	reqData.Confirmation.Type = "embedded"
	reqData.Confirmation.ReturnURL = "http://localhost:8000"

	jsonData, _ := json.Marshal(reqData)

	req, _ := http.NewRequest("POST", url, bytes.NewBuffer(jsonData))
	auth := base64.StdEncoding.EncodeToString([]byte(shopID + ":" + secretKey))
	req.Header.Add("Authorization", "Basic "+auth)
	req.Header.Add("Content-Type", "application/json")
	req.Header.Add("Idempotence-Key", uuid.New().String())

	client := http.Client{Timeout: 15 * time.Second}
	resp, err := client.Do(req)
	if err != nil {
		return "", err
	}
	defer resp.Body.Close()

	var paymentResp PaymentResponse
	json.NewDecoder(resp.Body).Decode(&paymentResp)

	return paymentResp.Confirmation.ConfirmationToken, nil
}

func main() {

	envPath := "../.env"
	if err := loadEnv(envPath); err != nil {
		log.Fatal("Failed to load .env:", err)
	}
	shopID := os.Getenv("SHOP_ID")
	secretKey := os.Getenv("SECRET_KEY")

	log.Println("SHOP_ID:", shopID)
	log.Println("SECRET_KEY:", secretKey)

	http.HandleFunc("/create-payment", func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Access-Control-Allow-Origin", "*")
		w.Header().Set("Content-Type", "application/json")

		token, err := createPayment(shopID, secretKey)
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		json.NewEncoder(w).Encode(map[string]string{
			"confirmation_token": token,
		})
	})

	log.Println("Go YooKassa server started on :8300")
	http.ListenAndServe(":8300", nil)
}
