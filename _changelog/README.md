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
