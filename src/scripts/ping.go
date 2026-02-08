package main

import (
	"fmt"
	"net"
	"sync"
	"time"
)

func anotherfunc() {
	hosts := []string{
		"google.com",
		"yandex.ru",
		"ru.wikipedia.org",
		"stackoverflow.com",
		"github.com",
	}
	var wg sync.WaitGroup

	for _, host := range hosts {
		wg.Add(1)
		go func(host string) {
			defer wg.Done()
			ping(host)
		}(host)
	}
	wg.Wait()
}

func ping(host string) {
	start := time.Now()
	_, err := net.LookupHost(host)
	duration := time.Since(start)
	if err != nil {
		fmt.Printf("Exception on ping %s: %s\n", host, err)
		return
	}
	fmt.Printf("Ping! %s, time: %dmcs\n", host, duration.Microseconds())
}
