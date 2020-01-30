# Snape's potion storage

## Description

Web application without particular frontend with small database, which helps its administrator to keep track of potions and ingredients in stock. It also enables adding and viewing recipes for potions. A regular user can only search and view a recipe without any other options. Administrator can control who gets viewing privileges. Users initially don't get privileges until administrator grants them.

## Usage

### For administrator


#### Homepage with autofill searchbar

![Admin Homepage](/screenshots/homepage.png)


#### Potions page (max 6 potions per page)

![Potions](/screenshots/potions.png)


#### Ingredients page

![Ingredients](/screenshots/ingredients.png)

#### Recipe for a potion
Viewing a recipe for a potion, administrator can calculate needed amount and also store potions after making them in which case the amount of potions in storage is increased and amount of ingredients from the storage is decreased.

![Recipe](/screenshots/recipe.png)

#### Adding new recipe
In a case in which a recipe for a certain potion doesn't exist the administrator can add one.

![Adding Recipe](/screenshots/addrecipe.png)

#### Users
Users page where administrator can grant or revoke privileges for a registered user.

![Users](/screenshots/users.png)


### For a regular user

#### Homepage

![Regular user homepage](/screenshots/regularuser.png)

#### Potion recipe view
Regular user doesn't have an option to store made potions.

![Regular user recipe view](/screenshots/userrecipeview.png)

