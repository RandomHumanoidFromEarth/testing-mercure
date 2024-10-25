# Testing Real-Time-Notifications with Mercure
This project is only for testing mercure and understanding the concepts.
## Starting the project
```sh
symfony server:start --no-tls -d
docker compose up -d
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate --no-interaction
```
## Overview
There are two entities: Puppy and Owner.<br/>
Puppies are owned by Owners.<br/>
The IndexController gives you an overview.<br/>
By default you subscribe to all topics.<br>
You can choose to only subscribe to one user in the table.<br/>
Beware security concepts and photoshop design in this project. (ironic)<br/>
It's just for testing and understanding.

## Using it
Start by loading the postman-collection from the project.<br/>
Create two new Owners.<br/>
Visit: `http://127.0.0.1:8000`.<br/>
Now you subscribed all.<br/>
Try adding a doggo to owner one.<br/>
You should get an alert.<br/>
Try adding a doggo to owner two.<br/>
You should also get an alert.<br/>
Then subscribe only to user 1.<br/>
Modify one his/her doggos.<br/>
You should get an alert.<br/>
Then modify a doggo of owner 2.<br/>
There should not be an alert.<br/>
<br/>
Api documentation: http://127.0.0.1:8000/api/docs


## How is my message secured from other users
Because of JWT claims. The twig function `mercure()` will create a signed<br/>
JWT with claims. This is backend and can not be modified by the user.

## Further reading
- `App\Entity\Puppy::getMercureOptions()`
- https://api-platform.com/docs/core/mercure/
- https://symfony.com/doc/current/mercure.html
