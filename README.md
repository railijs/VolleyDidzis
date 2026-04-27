# VolleyLV

VolleyLV ir tīmekļa lietotne pludmales volejbola turnīru pārvaldībai Latvijā. Tā ļauj lietotājiem reģistrēties, izveidot un pievienoties turnīriem, sekot spēļu rezultātiem un skatīt rezultātu tabulas.

## Funkcijas

- **Lietotāju reģistrācija un autentifikācija**: Droša pieteikšanās un reģistrācija ar latviešu valodas atbalstu
- **Turnīru pārvaldība**: Izveidot, rediģēt un pārvaldīt volejbola turnīrus
- **Komandu reģistrācija**: Komandas var pieteikties dalībai turnīros
- **Izlases sistēma**: Automātiska viena izslēgšanas izlase
- **Spēļu izsekošana**: Reģistrēt rezultātus un sekot turnīra norisei
- **Rezultātu tabulas**: Skatīt turnīra statistiku un rangus
- **Ziņu sistēma**: Publicēt un attēlot turnīra ziņas un jaunumus
- **Adaptīvs dizains**: Mobilajām ierīcēm draudzīgs interfeiss, izveidots ar Tailwind CSS

## Izmantotās tehnoloģijas

- **Aizmugure**: Laravel 12 (PHP 8.2+)
- **Priekšpuse**: Blade šabloni, Alpine.js, Tailwind CSS
- **Datubāze**: MySQL/PostgreSQL (izmantojot Laravel migrācijas)
- **Autentifikācija**: Laravel Breeze
- **Testēšana**: Pest PHP
- **Būvēšanas rīks**: Vite

## Instalācija

### Priekšnosacījumi

- PHP 8.2 vai jaunāka versija
- Composer
- Node.js un npm
- MySQL vai PostgreSQL datubāze

### Uzstādīšana

1. **Klonēt repozitoriju**

    ```bash
    git clone <repozitorija-url>
    cd volitis
    ```

2. **Instalēt PHP atkarības**

    ```bash
    composer install
    ```

3. **Instalēt Node.js atkarības**

    ```bash
    npm install
    ```

4. **Vides konfigurācija**

    ```bash
    cp .env.example .env
    ```

    Atjauniniet `.env` failu ar saviem datubāzes akreditācijas datiem un citiem iestatījumiem.

5. **Ģenerēt lietotnes atslēgu**

    ```bash
    php artisan key:generate
    ```

6. **Palaist datubāzes migrācijas**

    ```bash
    php artisan migrate
    ```

7. **Aizpildīt datubāzi (pēc izvēles)**

    ```bash
    php artisan db:seed
    ```

8. **Būvēt resursus**

    ```bash
    npm run build
    ```

9. **Palaist izstrādes serveri**

    ```bash
    php artisan serve
    ```

10. **Palaist Vite resursu kompilācijai (atsevišķā terminālī)**
    ```bash
    npm run dev
    ```

Apmeklējiet `http://localhost:8000`, lai piekļūtu lietotnei.

## Lietošana

### Lietotājiem

- Reģistrēt kontu vai pieteikties
- Pārlūkot pieejamos turnīrus
- Pievienoties turnīriem kā komandas kapteinis
- Skatīt turnīra izlases un rezultātus
- Pārbaudīt rezultātu tabulas un statistiku

### Administratoriem

- Izveidot un pārvaldīt turnīrus
- Pārvaldīt lietotāju kontus
- Publicēt ziņu rakstus
- Sekot turnīra norisei

## Testēšana

Palaist testu komplektu ar Pest:

```bash
php artisan test
```

## Veicināšana

1. Forkēt repozitoriju
2. Izveidot funkcijas zaru (`git checkout -b feature/briniska-funkcija`)
3. Veikt izmaiņas (`git commit -m 'Pievienot kādu brīnisku funkciju'`)
4. Nosūtīt uz zaru (`git push origin feature/briniska-funkcija`)
5. Atvērt Pull Request

## Licence

Šis projekts ir licencēts saskaņā ar MIT licenci - skatiet [LICENSE](LICENSE) failu, lai iegūtu sīkāku informāciju.

## Atbalsts

Lai saņemtu atbalstu, lūdzu, sazinieties ar izstrādes komandu vai izveidojiet jautājumu repozitorijā.
