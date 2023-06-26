**Laravel Boolfolio - Project Technology**
===
## **Descrizione esercizio precedente**
Creare un nuovo progetto con Laravel Breeze ed il pacchetto Laravel 9 Preset con autenticazione.

Separare gli ambienti Guest da quelli Admin per quanto riguarda: stili, js, controller, viste e layout.

Infine creare la CRUD(Create, Read, Update e Delete) di un Portfolio.

Include nella CRUD del portfolio l’aggiunta dell’immagine e la sua relativa eliminazione.

# **Laravel One To Many**
## **Descrizione esercizio precedente**
Continuare a lavorare su un progetto precedente (laravel-auth) ma in una nuova repo e aggiungere una nuova entità **Type**. 

Questa entità rappresenta la tipologia di progetto ed è in relazione **one to many** con i progetti.

I task da svolgere sono:
- creare la migration per la tabella `types`
- creare il model `Type`
- creare la migration di modifica per la tabella `projects` per aggiungere la chiave esterna
- aggiungere ai model Type e Project i metodi per definire la relazione one to many
- visualizzare nella pagina di dettaglio di un progetto la tipologia associata, se presente
- permettere all’utente di associare una tipologia nella pagina di creazione e la modifica di un progetto
- gestire il salvataggio dell’associazione progetto-tipologia con opportune regole di validazione

Creare il seeder per il model Type e il seeder della tabella ‘projects’ con l’id del type (random) in relazione

Aggiungere le operazioni CRUD per il model Type, in modo da gestire le tipologie di progetto direttamente dal pannello di amministrazione.

# **Laravel Many To Many**
## **Descrizione esercizio precedente**

Continuare a lavorare su un progetto precedente (laravel-one-to-many), ma in una nuova repo e aggiugendo una nuova entità **Technology**. 

Questa entità rappresenta le tecnologie utilizzate ed è in relazione **many to many** con i progetti.

I task da svolgere sono:
- creare la migration per la tabella `technologies`
- creare il model `Technology`
- creare la migration per la tabella pivot `project_technology`
- aggiungere ai model Technology e Project i metodi per definire la relazione many to many
- visualizzare nella pagina di dettaglio di un progetto le tecnologie utilizzate, se presenti
- permettere all’utente di associare le tecnologie nella pagina di creazione e modifica di un progetto
- gestire il salvataggio dell’associazione progetto-tecnologie con opportune regole di validazione

Creare il seeder per il model Technology e per la tabella pivot.

Aggiungere le operazioni CRUD per il model Technology, in modo da gestire le tecnologie utilizzate nei progetti direttamente dal pannello di amministrazione.

# **Laravel Boolfolio - API**
## **Descrizione esercizio attuale da svolgere**
Continuare a lavorare su un progetto precedente (laravel-many-to-many) ma in una nuova repo (laravel-api). 

**Milestone 1**

Nome repo 1: laravel-api

Aggiungere al progetto Laravel un nuovo **Api/ProjectController**. 

Questo controller risponderà a delle richieste via API e si occuperà di restituire la lista dei progetti presenti nel database in formato json.

**Milestone 2**

Testare la chiamata API tramite Postman o Tunder Client e 
assicurarsi di ricevere i dati correttamente.

**Milestone 3**

Nome repo 2: vite-boolfolio

Iniziare ad occuparsi della parte front-office dell'applicazione: creare un nuovo progetto Vue 3 con Vite e installare axios.

Collegare questo progetto ad una repo separata.

**Milestone 4**

Nel componente principale della Vue App fare una 
chiamata API all’endpoint costruito nel progetto Laravel (milestone 1) e recuperare tutti i progetti dal back-end.

Stampare in console i risultati e verificare di ricevere i dati correttamente.

**Milestone 5**

Creare un nuovo componente ProjectCard, che corrisponde ad una card per visualizzare un progetto. Utilizzare questo componente per visualizzare tutti i progetti ricevuti tramite API.

## **Bonus:**

1. Gestire la paginazione dei risultati
2. ‘Innestare’ vue all’interno del progetto Laravel e da lì fare la chiamata API

---------------------------------------

# **Passaggi**

## **Creare un progetto con Breeze integrato**


1. 

composer create-project --prefer-dist laravel/laravel:^9.2 nome_progetto

OPPURE (MENO PREFERIBILE)

composer create-project laravel/laravel:^9.2 nome-cartella


2. PER ENTRARE NELLA CARTELLA !!! IMPORTANTE

cd nome-cartella


3. !!! Dentro la cartella !!!

composer require laravel/breeze --dev

OPPURE (MENO PREFERIBILE)

composer require laravel/breeze

4. 
php artisan breeze:install

CLICCARE:
0
INVIO
INVIO

5. 
composer require pacificdev/laravel_9_preset

6. !!! IMPORTANTE AGGIUNGERE --auth

php artisan preset:ui bootstrap --auth


---------------------------------------

npm i

composer install

---------------------------------------

php artisan key:generate 

npm run dev

php artisan serve

--------------------------------------

## **PASSAGGI SUCCESSIVI**

- creare un DATABASE in myPhpAdmin e collegarlo nel file .env inserendo il nome

- php artisan migrate

-------------------

- creare i file nelle cartelle resources/js e resources/scss 
	- in resources/js ->     appGuest.js
	- in resources/scss ->   appGuest.scss 
	- importare bootstrap -> @import '~bootstrap/scss/bootstrap';

- Aggiungere i percorsi in " vite.config.js "
	- modificare l'input in =  input: ['resources/scss/app.scss', 'resources/js/app.js', 'resources/scss/appGuest.scss', 'resources/js/appGuest.js'],

- in " views/layout/guest.blade.php " cambiare la riga @vite da css a scss
	- @vite(['resources/scss/appGuest.scss', 'resoureces/js/appGuest.js'])

- in " App/Http/Providers/RouteServiceProvider.php " sostituire la parola /dashboard con /admin  
	- public const HOME = '/admin';

--------------------------------------

- creare una cartella " guest " nelle view
	- creare un file home.blade.php

- Creare il controller Guest/PageController 
	- php artisan make:controller Guest/PageController 

- richiamare nel controller Guest/PageController la function index per restituire la view di guest.home
	- class PageController extends Controller{
		public function index(){
			return view('guest.home');
		}
	  }

- richiamare la rotta in route/web.php (*cancellare le altre rotte di default)
	- use App\Http\Controllers\Guest\PageController;
	- Route::get('/', [PageController::class, 'index'])->name('home');

--------------------------------------

- Creare una cartella " admin " nelle view
	- creare un file home.blade.php
	- Copiare il CONTENUTO del file " dashboard.blade.pphp " ed incollare all'interno di " home.blade.php "

- Creare il controller Admin/DashboardController 
	- php artisan make:controller Admin/DashboardController 

- richiamare nel controller Admin/DashboardController la function index per restituire la view di admin.home
	- class PageController extends Controller{
		public function index(){
			return view('admin.home');
		}
	  }

- Aggiungere la rotta nella route/web.php USANDO MIDDLEWARE
	- use App\Http\Controllers\Admin\DashboardController;
	- Route::middleware(['auth', 'verfied'])
		->name('admin')
		->prefix('admin')
		->group(function(){
			Route::get('/', [DashboardController::class, index])->name('home');
		});

--------------------------------

- Eliminare i file di default
	- dashboard.blade.php
	- welcome.blade.php

-------------------------------
# **CRUD**

## **Breve riepilogo: Rotte resource**

**comics.index** -> GET -> funzione del controller: index -> view: comics.index

**comics.show/{comic}** -> GET -> funzione del controller: show -> view: comics.show

---------------------------------------------------

**comics.create** -> GET -> funzione del controller: create -> view: comics.create (contiene il form di creazione)

**comics.create** INVIA IL FORM IN ***POST*** a comics.store

**comics.store** -> ***POST*** -> controlla la validità del dato, lo salva  e reindirizza a comics.show

---------------------------------------------------

**comics.edit{comic}** -> GET -> funzione del controller: edit -> view: **comics.edit** (contiene il form di modifica)

**comics.edit** INVIA IL FORM IN PUT a comics.update

---------------------------------------------------

**comics.update** -> ***PUT*** -> controlla la validità del dato, lo aggiorna  e reindirizza a comics.show

---------------------------------------------------

**comics.destroy** -> ***DELETE*** -> elimina il dato e reindirizza a comics.index
