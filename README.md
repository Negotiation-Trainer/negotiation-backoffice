<img src="https://github.com/Negotiation-Trainer/negotiation-trainer/blob/a1cf9afacd9900871d50bc5115f7474f1c6a1523/Assets/Connor's%20Paradise%20Logo.png?raw=true" width="200px" alt=""/>

# Connor's Paradise Negotiation Trainer - Backoffice Website
*Based on [Connor Paradise by The Negotiation Challenge](https://professionals.thenegotiationchallenge.org/downloads/connor-paradise/)*
## General Information
![GitHub last commit](https://img.shields.io/github/last-commit/Negotiation-Trainer/negotiation-backoffice) ![GitHub License](https://img.shields.io/github/license/Negotiation-Trainer/negotiation-backoffice)

### Overview
The Negotiation Backoffice is used to grant AI conversations to the Unity Game. The backoffice is a web application that allows the game administrator to manage the game settings, create new games, and view the game results. The backoffice is built using Laravel and Vue.js.

### Repository Information
This repository is the backoffice website for the game. The backoffice is a web application that allows the game administrator to manage the game settings, create new games, and view the game results. The backoffice is built using Laravel and Vue.js

The game repository itself can be found [here](https://github.com/Negotiation-Trainer/negotiation-trainer), as well as more information about the game.


## 🛠️ Tech Stack
- Laravel
- Vue.js
- MySQL

## 🚀 Features
- Create new games
- Manage game settings
- View game results
- View AI budgets and costs

## 🛠️ Getting Started
To get a local copy up and running follow these simple steps.
1. Clone the repository
2. Install the dependencies using `composer install` and `npm install`
3. Create a new database and configure the .env file, you can run `cp .env.example .env` to create a new .env file. More information about the database configuration can be found [here](https://laravel.com/docs/10.x/database)
4. Run the migrations using `php artisan migrate`
5. Run the server using `php artisan serve`
6. Build the front-end using `npm run build` or run the development server using `npm run dev`
7. Access the website at `http://localhost:8000`
8. You'll see a setup page, where you can create a new admin user
9. You can now access the backoffice using the credentials you just created. You can now create new games, manage game settings, and view costs.

You can also deploy this to a server, more information about deploying a Laravel application can be found [here](https://laravel.com/docs/10.x/deployment)
The build workflow for this repository shows the steps to deploy the application to a server, in this case to an Azure App Service.

## 🍰 Contributing
Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

Before contributing, please read the [code of conduct](CODE_OF_CONDUCT.md).

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement". Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch `(git checkout -b feature/AmazingFeature)`
3. Commit your Changes `(git commit -m 'Add some AmazingFeature')` (We would suggest using [atomic commits](https://dev.to/this-is-learning/the-power-of-atomic-commits-in-git-how-and-why-to-do-it-54mn) 😉)
4. Push to the Branch `(git push origin feature/AmazingFeature)`
5. Open a Pull Request

## ➤ License
Distributed under the GPL-3.0 License. See [LICENSE](LICENSE) for more information.
