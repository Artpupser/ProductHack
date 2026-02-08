package main

import (
	"bytes"
	"encoding/base64"
	"encoding/json"
	"log"
	"net/http"
	"os"
	"strconv"
	"time"

	"github.com/joho/godotenv"
)

type PaymentRequest struct {
	Amount struct {
		Value    string `json:"value"`
		Currency string `json:"currency"`
	} `json:"amount"`
	Confirmation struct {
		Type      string `json:"type"`
		ReturnURL string `json:"return_url"`
	} `json:"confirmation"`
	Capture     bool   `json:"capture"`
	Description string `json:"description"`
}

type PaymentResponse struct {
	Confirmation struct {
		ConfirmationURL string `json:"confirmation_url"`
	} `json:"confirmation"`
}

func createPayment(shopID, secretKey string) (string, error) {
	reqBody := PaymentRequest{}
	reqBody.Amount.Value = "100.00"
	reqBody.Amount.Currency = "RUB"
	reqBody.Confirmation.Type = "redirect"
	reqBody.Confirmation.ReturnURL = "http://localhost:8300/success"
	reqBody.Capture = true
	reqBody.Description = "Тестовая оплата"

	jsonBody, _ := json.Marshal(reqBody)

	req, _ := http.NewRequest("POST", "https://api.yookassa.ru/v3/payments", bytes.NewBuffer(jsonBody))
	auth := base64.StdEncoding.EncodeToString([]byte(shopID + ":" + secretKey))
	req.Header.Set("Authorization", "Basic "+auth)
	req.Header.Set("Content-Type", "application/json")

	idempotenceKey := "payment-" + strconv.FormatInt(time.Now().UnixNano(), 10)
	req.Header.Set("Idempotence-Key", idempotenceKey)

	client := &http.Client{Timeout: 10 * time.Second}
	resp, err := client.Do(req)
	if err != nil {
		return "", err
	}
	defer resp.Body.Close()

	var paymentResp PaymentResponse
	json.NewDecoder(resp.Body).Decode(&paymentResp)

	return paymentResp.Confirmation.ConfirmationURL, nil
}

func main() {
	// Загружаем .env из текущей папки
	if err := godotenv.Load(".env"); err != nil {
		log.Fatal("Не удалось загрузить .env")
	}

	shopID := os.Getenv("SHOP_ID")
	secretKey := os.Getenv("SECRET_KEY")
	if shopID == "" || secretKey == "" {
		log.Fatal("Не заданы SHOP_ID или SECRET_KEY в .env")
	}

	http.HandleFunc("/pay/ukassa", func(w http.ResponseWriter, r *http.Request) {
		url, err := createPayment(shopID, secretKey)
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}
		if url == "" {
			http.Error(w, "Ошибка: confirmation_url пустой", 500)
			return
		}
		http.Redirect(w, r, url, http.StatusSeeOther)
	})

	http.HandleFunc("/success", func(w http.ResponseWriter, r *http.Request) {
		w.Write([]byte("<h1>✅ Оплата прошла успешно (sandbox)</h1>"))
	})

	log.Println("Go-сервер запущен на http://localhost:8300")
	log.Fatal(http.ListenAndServe(":8300", nil))
}
