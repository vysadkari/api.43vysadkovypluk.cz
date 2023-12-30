<p align="center">
  <a href="https://43vysadkovypluk.cz" target="_blank">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/vysadkari/api.43vysadkovypluk.cz/HEAD/.github/wings-white.svg">
      <source media="(prefers-color-scheme: light)" srcset="https://raw.githubusercontent.com/vysadkari/api.43vysadkovypluk.cz/HEAD/.github/wings-black.svg">
      <img alt="43. výsadkový pluk" src="https://raw.githubusercontent.com/vysadkari/api.43vysadkovypluk.cz/HEAD/.github/wings-black.svg" width="326" height="142" style="max-width: 100%;">
    </picture>
  </a>
</p>

<p align="center">
  API pro webovou prezentaci 43. výsadkového pluku.
</p>

---

## Obsah

- [Obsah](#obsah)
- [Instalace a spuštění](#instalace-a-spuštění)
- [Endpointy](#endpointy)
  - [`/candidate` \[POST\]](#candidate-post)
  - [`/contact` \[GET\]](#contact-get)
  - [`/selection` \[GET\]](#selection-get)
  - [`/system/clear-cache` \[GET\]](#systemclear-cache-get)
- [Povolené domény](#povolené-domény)
- [Nasazení na produkci](#nasazení-na-produkci)

## Instalace a spuštění

API běží na **Symfony 6.4** a **PHP 8.1**.

1. Stažení repozitáře
2. Instalace závislostí: `composer install`
3. Spuštění lokálního PHP serveru ([Symfony CLI](https://symfony.com/download)): `symfony server:start`

## Endpointy

### `/candidate` [POST]

Vytvoření nového uchazeče z kontaktního formuláře. Endpoint na vstupu přijímá:

- `name` - jméno a příjmení uchazeče
- `phoneNumber` - telefonní číslo
- `email` - email uchazeče
- `message` - zpráva (_nepovinné_)

Odpověď je v případě úspěšného založení uchazeče token, který slouží pro nastavení hesla do aplikace pro uchazeče:

```json
{
  "token": "d77d7faf-bb3e-456b-bbef-7ba7ce96ed07"
}
```

V případě chyby (například špatně vyplněný formulář) je to popis a HTTP kód `400`:

```json
{
  "message": "Jméno je prázdné"
}
```

### `/contact` [GET]

Načtení kontaktních informací - adresa, telefony a emaily. Data jsou dočasně načítána staticky z verzovaných textových souborů uložených v adresáři `/data`, konkrétně `adresa.txt`, `email.txt` a `telefon.txt`.

```json
{
  "address": {
    "address": "Obce Ležáků 14, 573 01 Chrudim",
    "mapLink": "https://mapy.cz/s/bamumocava"
  },
  "phone": [
    {
      "phoneNumber": "973248010",
      "title": "personální oddělení"
    },
    {
      "phoneNumber": "702008503",
      "title": "tiskový mluvčí"
    }
  ],
  "email": ["info@43vysadkovypluk.cz", "az@43vysadkovypluk.cz"]
}
```

### `/selection` [GET]

Načtení termínu výběrových řízení. Data jsou dočasně načítána staticky z verzovaného textového souboru `/data/terminy-vr.txt`. API automaticky filtruje termíny, které jsou již v minulosti a v odpovědi je nevrací.

```json
{
  "next": "2024-04-01",
  "following": ["2024-06-18"]
}
```

### `/system/clear-cache` [GET]

Endpoint **vyžadující autorizaci**, který slouží ke smazání cache po nasazení změn na FTP. Autorizace se provádí přes _Bearer Token_ a token se do aplikace doplňuje až během nasazení. V případě úspěšné autorizace a smazání cache vrací:

```json
{
  "message": "Cache is trash"
}
```

V každém jiném případě:

```json
{
  "message": "Cache is what it is"
}
```

## Povolené domény

API pracuje s hlavičkou `Access-Control-Allow-Origin`, aby bylo možné ho volat pouze z daného seznamu domén:

- http://localhost:4321
- https://test.43vysadkovypluk.cz
- https://43vysadkovypluk.cz

Případná další rozšíření seznamu domén je potřeba udělat v souboru `/config/services.yaml`, konkrétně do parametru `app.allowedOrigins`.

## Nasazení na produkci

Nasazení na produkční FTP je prováděno automaticky po pushnutí do master větve pomocí GitHub Actions.
