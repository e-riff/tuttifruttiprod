# Architecture

Ce projet utilise une architecture inspiree DDD / hexagonale, volontairement legere.

L'objectif n'est pas d'appliquer un DDD pur sur un petit site vitrine, mais de rendre les responsabilites plus lisibles tout en gardant les integrations Symfony utiles : Doctrine ORM, Symfony Forms, VichUploader, Twig, le router, et potentiellement API Platform plus tard.

## Organisation

`src/` contient trois zones principales, plus `Kernel.php` qui reste le point d'entree standard Symfony.

### Domain

`Domain/` contient le vocabulaire metier que l'on veut garder au centre :

- les enums metier ;
- les objets de criteres metier, par exemple `BandSearchCriteria` ;
- les interfaces de repository.

Les interfaces de repository sont ici parce qu'elles representent ce dont le modele et les cas d'usage ont besoin pour lire ou persister le metier. Les implementations concretes restent dans l'infrastructure Doctrine.

### Application

`Application/` contient les cas d'usage et les ports non-repository.

Un cas d'usage orchestre une action applicative sans connaitre les details HTTP, Twig ou Doctrine. Par exemple, envoyer un message de contact ou lister les groupes mis en avant.

Les ports non-repository restent dans `Application` quand ils representent une capacite applicative externe, comme l'envoi d'un message. L'implementation concrete, elle, est dans `Infrastructure`.

### Infrastructure

`Infrastructure/` contient les details techniques :

- les entites Doctrine ;
- les repositories Doctrine ;
- les controllers Symfony ;
- les forms ;
- les commands ;
- les listeners ;
- les fixtures ;
- les adapters mail, SEO et Twig.

Les controllers sont dans `Infrastructure/Symfony/Controller` parce qu'ils dependent directement de Symfony : routes, requetes HTTP, formulaires, redirects, flashes et rendu Twig. Ils restent minces et deleguent a `Application` quand il y a une logique applicative.

## Fuites assumees de l'infra

Le projet garde volontairement des fuites d'infrastructure dans le domaine et l'application.

La principale fuite est le modele persistant : les entites Doctrine/Vich restent les objets manipules par les repositories, les forms et plusieurs cas d'usage. C'est un compromis assume pour eviter de dupliquer un modele metier complet qui n'apporterait pas assez de valeur a ce stade.

Autre fuite : certaines interfaces de repository du domaine typent leurs retours avec les entites Doctrine. Ce n'est pas hexagonal pur, mais c'est coherent avec l'objectif du projet : decoupler les usages et les implementations sans casser l'ergonomie Symfony.

Si le metier grossit, la prochaine etape serait d'introduire progressivement des modeles metier dedies ou des DTO de lecture sur les zones qui en ont vraiment besoin, pas partout par principe.

## Choix pratique

Symfony garde son role de framework d'application.
Doctrine reste l'adapter de persistence principal.
Les interfaces sont utilisees quand elles apportent une vraie separation :
- interfaces de repository dans `Domain` ;
- ports applicatifs non-repository dans `Application` ;
- implementations concretes dans `Infrastructure`.

## UI
La homepage sert aujourd'hui de premiere direction UI modernisee. Le reste de l'interface pourra etre aligne progressivement selon les retours client, sans bloquer le refactor technique.
