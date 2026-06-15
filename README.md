# Laboratorium 13 + 13D

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
### Weryfikacja uruchomienia kontenerów
```
docker compose ps
```
### Weryfikacja działania sieci i fragmentacji
```
docker network ls

docker network inspect lab13_back | jq '.[].Containers'
docker network inspect lab13_front | jq '.[].Containers'

```
### Działanie aplikacji
```
curl http://localhost:4001"
```
### Potwierdzenie inicjalizacji mysql
```
docker compose logs mysql | grep -i -E "ready for connections|database|user"
```
### Utworzenie testowej bazy danych na koncie roota
