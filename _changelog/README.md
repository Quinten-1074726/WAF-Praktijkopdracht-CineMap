# CineMap – Changelog

Welkom bij de changelog van **CineMap**, mijn praktijkopdracht voor het vak **Web Application Frameworks (WAF)**.  
In dit logboek houd ik mijn **voortgang**, **bevindingen** en **bronnen** bij per dag dat ik aan het project werk.

De changelog helpt om inzicht te krijgen in wat ik heb gedaan, wat goed ging en waar ik feedback of hulp bij nodig had.  
De **meest recente datum** komt altijd **bovenaan** te staan.

---

## Changelog overzicht

Hieronder komen de logboeken per dag (vanaf les 3).  
Elke sectie krijgt de volgende structuur:

## 📅 Changelog

### **31 oktober 2025**
**FIX: Security fix to save watchlist item**  
- 404-fout bij opslaan van watchlist opgelost (route model binding gefixt).  
- Validatie aangescherpt en eigenaar-check toegevoegd bij updates/verwijderingen.  

**FIX: Watchlist status fix en extra beveiliging**  
- Validatie toegevoegd voor toegestane statussen (`WIL_KIJKEN`, `BEZIG`, `GEZIEN`).  
- Logica toegevoegd zodat gebruikers pas een review/rating kunnen plaatsen na minimaal 5 “Gezien”-titels.  
- Frontend (Alpine.js) bijgewerkt: velden worden automatisch uitgeschakeld als gebruiker nog niet genoeg gezien heeft.  

**ADD: Genres aan titels**  
- Koppeltabel toegevoegd tussen titels en genres (`title_genre`).  
- Titels kunnen nu meerdere genres hebben.  
- Admin kan genres selecteren bij het aanmaken/bewerken van titels.  

**ADD: Platform CRUD voor admin**  
- Beheerpagina toegevoegd voor platforms (aanmaken, bewerken, verwijderen).  
- Validatie op unieke naam toegevoegd.  
- Seeder gemaakt met standaardplatforms (Netflix, Disney+, Prime Video, HBO Max).  

**ADD: Genres CRUD voor admin**  
- Admin kan genres aanmaken, bewerken en verwijderen via dashboard.  
- Seeder met 10 standaardgenres toegevoegd.  

**UPDATE: Styling watchlist**  
- Layout verbeterd: duidelijkere scheiding tussen kaarten, knoppen en formulieren.  
- Nieuwe dynamische velden voor status/rating/review met Alpine.js.  

**ADD: Watchlist pagina en functies**  
- Nieuwe pagina voor watchlist-overzicht per gebruiker.  
- Functies toegevoegd voor toevoegen, bewerken, filteren en verwijderen van titels uit watchlist.  

**ADD: Afbeeldingen toegevoegd aan titels**  
- Nieuwe migratie voor afbeeldingskolom bij `titles`-tabel.  
- Controllers en views aangepast zodat posters getoond worden.  
- Alle bestaande titels voorzien van voorbeeldafbeeldingen.  

---

### **30 oktober 2025**
**ADD: Admin dashboard, routes en controllers**  
- Nieuw admin-dashboard toegevoegd met overzicht van gebruikers, titels en platforms.  
- Navigatie en toegangscontrole toegevoegd voor admins.  

**ADD: Edit user role als admin**  
- Beheerders kunnen nu de rol van gebruikers aanpassen (gebruiker ↔ admin).  

**ADD: Filters en zoekfunctie op admin titels**  
- Zoekbalk en filteropties toegevoegd aan de admin-pagina voor titels.  
- Mogelijkheid om ongepubliceerde titels te filteren.  

**ADD: Admin CRUD voor titels**  
- Volledige CRUD-functionaliteit voor titels binnen admin-dashboard.  
- Mogelijkheid om titels te publiceren of te verbergen.  
- Beelduploads toegevoegd voor titels.  

**FIX: Homepage met titels en detailpagina**  
- Publieke homepage toont nu alle gepubliceerde titels in grid-layout.  
- Detailpagina’s tonen titel, beschrijving, jaar, type, genres en platform.  

---

### **28 oktober 2025**
**ADD: Seeders voor basisdata (titels en gebruikers)**  
- Seeder toegevoegd voor admin en standaardgebruiker.  
- Seeder voor titels met o.a. Goodfellas, Inception, Gladiator, Dune: Part Two, Interstellar, Game of Thrones, Band of Brothers, The Sopranos, Rome en Breaking Bad.  

**ADD: Alle migraties en relaties toegevoegd en gefixt**  
- Relaties tussen Titles, Platforms, Genres en Watchlist-items gecontroleerd en hersteld.  
- Pivot-tabel toegevoegd voor koppeling tussen titles en genres.  

---

### **27 oktober 2025**
**UPDATE: Navbar en algemene styling toegevoegd**  
- Navigatiebalk gestyled in eigen CineMap-huisstijl (donker thema + accentkleuren).  
- Zoekveld toegevoegd aan navbar.  
- Basislayout (containers, kaarten, kleuren, knoppen) opgemaakt met Tailwind.  
- Consistente spacing en kleurgebruik toegepast op alle pagina’s.  

---

### **21 oktober 2025**
**Fix: Create title auth fix**  
- Validatie en authenticatie verbeterd bij het opslaan van titels.  
- `auth()->user()->id` toegevoegd zodat `user_id` correct wordt ingevuld.  
- Beveiliging toegevoegd: alleen ingelogde gebruikers kunnen titels aanmaken.  
- Dropdown toegevoegd aan het formulier voor platformselectie.  
- Validatie uitgebreid met `platform_id` (`exists:platforms,id`).  
- Relatie tussen titels en platforms getest en gevalideerd.  

---

### **15 oktober 2025**
**NEW: Platform model migration and joined with Titles**  
- Nieuw `Platform` model aangemaakt met `hasMany(Title::class)`-relatie.  
- `Title` model uitgebreid met `belongsTo(Platform::class)`.  
- Seeder toegevoegd voor standaardplatforms (Netflix, Disney+, Prime Video, HBO Max).  
- Database gecontroleerd in VS Code SQLite viewer.  

**NEW: Platform Migration created**  
- Nieuwe migratie voor de `platforms`-tabel toegevoegd.  
- Velden: `id`, `name`, `timestamps`.  

**NEW: Create and store function**  
- `TitleController` uitgebreid met `create` en `store` functies.  
- Eerste versie van `titles/create.blade.php` aangemaakt.  
- Validatie toegevoegd voor titel, type, beschrijving en jaar.  
- Data succesvol opgeslagen in SQLite via formulier en Tinker.  

---

### **14 oktober 2025**
**NEW: Migrations added**  
- Eerste migratie voor de `titles`-tabel aangemaakt.  
- Velden: `title`, `type`, `description`, `year`, `is_published`, `user_id`, `platform_id`.  
- Relaties voorbereid voor toekomstige koppeling met gebruikers en platforms.  

---

### **12 oktober 2025**
**Initial commit: Laravel + Breeze scaffold**  
- Nieuw Laravel-project opgezet met Breeze-authenticatie.  
- Basisprojectstructuur aangemaakt (`routes`, `models`, `views`).  
- GitHub-repository geïnitieerd.  

**docs(changelog): add _changelog/README and images folder**  
- Documentatie- en afbeeldingsmappen toegevoegd.  
- Eerste README en changelog-bestanden opgesteld.  
