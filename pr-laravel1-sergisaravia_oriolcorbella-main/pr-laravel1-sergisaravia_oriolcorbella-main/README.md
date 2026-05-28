# Descripció del projecte:
RPG Inventory API és una API backend desenvolupada amb Laravel que permet gestionar:

- Personatges d’un jugador
- Catàleg d’ítems del joc
- Moviments d’inventari (loot, equip, unequip, drop)
- Càlcul dinàmic de l’inventari i l’equipament
- Registre de logs a MongoDB

# Arquitectura del projecte:
El projecte s’ha desenvolupat seguint les bones pràctiques de Laravel:

- Controladors lleugers
- Form Requests per a validacions
- Policies per al control d’accés
- Separació de la lògica en serveis
- Ús d’Eloquent ORM
- Arquitectura RESTful
- Persistència híbrida amb MySQL i MongoDB

#  Model de dades

## MySQL
### users
- id
- name
- email
- password
- role (admin | player)
- timestamps

### characters
- id
- name
- level
- user_id
- timestamps
- deleted_at (soft delete)

### items
- id
- name
- type (weapon, armor, consumable)
- slot (head, body, weapon, null)
- power
- timestamps

### inventory_movements
- id
- character_id
- item_id
- type (LOOT, EQUIP, UNEQUIP, DROP)
- executed_at
- timestamps

## MongoDB
Col·lecció: `logs`

Camps:
- action
- user_id
- character_id (opcional)
- item_id (opcional)
- metadata
- created_at

# Autenticació i rols

S’utilitza Laravel Sanctum amb access tokens.
Rols disponibles:
- admin
- player

Policies implementades:
- Un player només pot accedir als seus personatges
- L’admin pot accedir a tots els recursos
- Només l’admin pot crear, modificar o eliminar ítems

# Endpoints

## Characters

| Mètode | Endpoint |
|--------|----------|
| GET | /api/characters |
| GET | /api/characters/{id} |
| POST | /api/characters |
| PUT/PATCH | /api/characters/{id} |
| DELETE | /api/characters/{id} |

### BONUS – Soft Deletes
S’ha implementat Soft Delete a la taula `characters`.

## Endpoint addicional:
POST /api/characters/{id}/restore

## Items

| Mètode | Endpoint |
|--------|----------|
| GET | /api/items |
| GET | /api/items/{id} |
| POST | /api/items (admin) |
| PUT/PATCH | /api/items/{id} (admin) |
| DELETE | /api/items/{id} (admin) |


## Inventory Movements

| Mètode | Endpoint |
|--------|----------|
| POST | /api/inventory-movements |
| GET | /api/characters/{id}/inventory |
| GET | /api/characters/{id}/equipment |

Tipus de moviment:
- LOOT
- EQUIP
- UNEQUIP
- DROP

# Lògica d’inventari
No existeix una taula `inventory`.
L’inventari es calcula dinàmicament a partir de l’històric de moviments.
Regles implementades:
- LOOT afegeix l’ítem
- DROP elimina l’ítem
- EQUIP equipa l’ítem si està a l’inventari
- UNEQUIP retorna l’ítem a l’inventari
- No es pot equipar més d’un ítem per slot
- No es pot fer DROP d’un ítem equipat
- Les validacions de negoci es gestionen als Services, no als Form Requests

# Form Requests
Tots els endpoints que creen o modifiquen recursos utilitzen Form Requests.
Inclouen:
- Validació de tipus de dades
- Rang numèric coherent
- Enums per a type i slot
- No validen ownership
- No validen regles complexes de negoci

Links
- Link Video: https://drive.google.com/file/d/1w4ljiNfVhc6BTJip4BmXxUGAsmZooEUj/view?usp=drive_link
- Link Repositori: https://github.com/LSG-server-php-laravel/pr-laravel1-sergisaravia_oriolcorbella.git

# Cambios realizados respecto a la práctica 1

- Views implementadas:
    - CRUD Characters
    - CRUD Items (C, U, D solo admin)
    - Soft Delete de Items
    - View de restauración de Items Soft deleted_at
    - Inventory Movement
    - Lista de usuarios
    - Regitro y Login
    - Uso de Vite

- Uso de Observers (de Characters):
    - Valores predefinidos en los campos numéricos (level y health) cuando se está creando (creating)
    - Registros de Logs al crear y eliminar un usuario cuando se ha creado o eliminado (created y deleted, respectivamente)

- Addición de la Policy de Items para asegurarse de que los items solo los puede modificar el usuario

- Upload images:
    - Capacidad de subir imágenes desde el dispositivo
    - Validación de tipo y tamaño
    - Se guardan en /storage/app/public
    - Se actualiza la imagen y se elimina la imagen anterior
    - Se muestra en la pantalla
    - En Characters y en Items

- Controllers
    - Controller para la subida de imagenes
    - Coexistencia de lógica para API y para Web

- Seeders y Factories
    - Seeders de Admin y un User (el mío personal)
    - Factory para añadir algunos Characters en el nuevo User

- Link Vídeo Demo: https://drive.google.com/file/d/1_5abPiget3V1RgTZtQGi5u-qY6IcHIwR/view?usp=sharing

- Link Github: https://github.com/LSG-server-php-laravel/pr-laravel1-sergisaravia_oriolcorbella.git