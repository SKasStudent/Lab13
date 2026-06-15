# Laboratorium 13 + 13D

> [!NOTE]
> Na potrzeby udowodnienia poprawnego działania stosu lemp dodana została do php biblioteka mysqli, która
> podstawowo nie jest dołączana do obrazu.

## Architektura
|**Usługa**|**Obraz**|**Sieci**|**Port**|
|----------|---------|---------|--------|
|`nginx`|`nginx:1.31`|`frontend`,`backend`|`4001:80`|
|`php`|[Dockerfile](php/Dockerfile) (`php:8.5-fpm`)|`backend`|-|
|`mysql`|`mysql:9.7`|`backend`|-|
|`phpmyadmin`|`phpmyadmin:5.2.3`|`backend`|`6001:80`|

### Dlaczego phpmyadmin tylko w backend?
1. Phpmyadmin musi komunikować się z mysql - więc musiał znajdować się w sieci backend'owej. (`PMA_HOST: mysql`)
2. Dostęp z zewnątrz odbywa się poprzez udostępnienie portu `6001:80` na hoście i nie jest do tego wymagana przynależność do sieci frontendowej.
3. Dobrą praktyką jest udostępnianie jak najmniejszej ilości warstw aplikaji w sieci frontendowej, poniważ przyczynia się do do zmniejszenia możliwości atakującego w przypadku potencjalnego zagrożenia.

## Prezentacja działania aplikacji

### Uruchomienie aplikacji:
```
docker compose up -d --build
```
*--build odpowiada za zbudowanie obrazu php.*

**Wynik:**

<img width="865" height="559" alt="Screenshot From 2026-06-15 19-18-02" src="https://github.com/user-attachments/assets/d3aebf1a-437e-4b90-bea8-0d938e42553c" />

### Weryfikacja uruchomienia kontenerów
```
docker compose ps
```
**Wynik:**

<img width="1149" height="116" alt="Screenshot From 2026-06-15 19-20-27" src="https://github.com/user-attachments/assets/9e94cceb-09f3-43f4-ab02-cbf6f7f7cc18" />

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
curl http://localhost:4001
```
**Wynik:**

<img width="680" height="60" alt="Screenshot From 2026-06-15 19-03-11" src="https://github.com/user-attachments/assets/dce27381-aa53-41a2-beff-d284a9f4a2dd" />

<img width="434" height="200" alt="Screenshot From 2026-06-15 19-03-31" src="https://github.com/user-attachments/assets/aa174c9e-f6e4-468e-9312-13aeff20ea01" />

### Potwierdzenie inicjalizacji mysql
```
docker compose logs mysql | grep -i -E "ready for connections|database|user"
```
**Wynik:**
<img width="1033" height="436" alt="Screenshot From 2026-06-15 18-25-46" src="https://github.com/user-attachments/assets/7f864d57-1b92-4a3c-a124-936837fcd09a" />

### Utworzenie testowej bazy danych na koncie roota

**Logowanie:**

<img width="861" height="515" alt="Screenshot From 2026-06-15 19-07-31" src="https://github.com/user-attachments/assets/31d5adc1-0b2d-482e-8cef-16784511dbe6" />

**Tworzenie:**

<img width="861" height="515" alt="Screenshot From 2026-06-15 19-07-50" src="https://github.com/user-attachments/assets/89bba829-153f-4587-a3c3-6dde8d348cf0" />

**Po utworzeniu:**

<img width="861" height="515" alt="Screenshot From 2026-06-15 19-08-04" src="https://github.com/user-attachments/assets/0e149cf4-ed59-4042-bb56-47063b488276" />
