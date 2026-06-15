# Laboratorium 13 + 13D

> [!NOTE]
> Na potrzeby udowodnienia poprawnego działania stosu lemp dodana została do php biblioteka mysqli, która
> podstawowo nie jest dołączana do obrazu.

## Architektura
|**Usługa**|**Obraz**|**Sieci**|**Port**|
|----------|---------|---------|--------|
|`nginx`|`nginx:1.31`|`frontend`,`backend`|`4001:80`|
|`php`|`php:8.5-fpm`|`backend`|-|
|`mysql`|`mysql:9.7`|`backend`|-|
|`phpmyadmin`|`phpmyadmin:5.2.3`|`backend`|`6001:80`|

### Dlaczego phpmyadmin tylko w backend?
1. Phpmyadmin musi komunikować się z mysql - więc musiał znajdować się w sieci backend'owej. (`PMA_HOST: mysql`)
2. Dostęp z zewnątrz odbywa się poprzez udostępnienie portu `6001:80` na hoście i nie jest do tego wymagana przynależność do sieci frontendowej.
3. Dobrą praktyką jest udostępnianie jak najmniejszej ilości warstw aplikaji w sieci frontendowej, poniważ przyczynia się do do zmniejszenia możliwości atakującego w przypadku potencjalnego zagrożenia.

## Prezentacja działania aplikacji

### Uruchomienie aplikacji:
```
docker compose up -d
```
**Wynik:**

<img width="656" height="203" alt="Screenshot From 2026-06-15 18-22-29" src="https://github.com/user-attachments/assets/cf5c099e-b4f2-40cf-9931-78688ea13651" />

### Weryfikacja uruchomienia kontenerów
```
docker compose ps
```
**Wynik:**

<img width="656" height="226" alt="Screenshot From 2026-06-15 18-22-40" src="https://github.com/user-attachments/assets/685735b7-9c23-4e0a-ab9d-5663a4d9a30b" />

### Weryfikacja działania sieci i fragmentacji
```
docker network ls
```
**Wynik:**

<img width="656" height="154" alt="Screenshot From 2026-06-15 18-23-09" src="https://github.com/user-attachments/assets/15fda8b7-ff56-4702-92a2-e30bc6407aa7" />

```
docker network inspect lab13_back | jq '.[].Containers'
docker network inspect lab13_front | jq '.[].Containers'
```
**Wynik:**
Frontend:
<img width="911" height="170" alt="Screenshot From 2026-06-15 18-23-58" src="https://github.com/user-attachments/assets/fe722e48-d59c-4986-8953-1a47d3206d9a" />

Backend:
<img width="918" height="538" alt="Screenshot From 2026-06-15 18-24-10" src="https://github.com/user-attachments/assets/1092ee89-6b4c-4fb8-904d-01179e2f69fb" />

### Działanie aplikacji
```
curl http://localhost:4001"
```
**Wynik:**


### Potwierdzenie inicjalizacji mysql
```
docker compose logs mysql | grep -i -E "ready for connections|database|user"
```
**Wynik:**
<img width="1033" height="436" alt="Screenshot From 2026-06-15 18-25-46" src="https://github.com/user-attachments/assets/7f864d57-1b92-4a3c-a124-936837fcd09a" />

### Utworzenie testowej bazy danych na koncie roota
