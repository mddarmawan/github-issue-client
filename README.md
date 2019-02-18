# Github Issue Client
A dead simple page that allows you to give clients access to open a GitHub project issues

## How to use it
1. Simply clone this repo

`git clone https://github.com/mdandidarmawan/github-issue-client.git`

2. Copy `.env.example` to `.env`

- Linux: `cp .env.example .env`
- Windows: just copy to `.env` file

3. Edit your `.env` file

```
APP_NAME=YOUR_APP_NAME
APP_DESCRIPTION=YOUR_APP_DESCRIPTION

GITHUB_USERNAME=YOUR_GITHUB_USERNAME
GITHUB_PASSWORD=YOUR_GITHUB_PASSWORD
GITHUB_AUTHOR=YOUR_REPOSITORY_AUTHOR
GITHUB_REPO=YOUR_REPOSITORY
```

__Note: if your repository isn't private, you can skip the `GITHUB_USERNAME` and `GITHUB_PASSWORD`__

4. Run your server at that folder

- PHP: `php -S 127.0.0.1:8000 -t github-issue-client`
- If you using bundling software (XAMPP, LAMPP, WAMPP), just copy to the **htdocs** folder and go to `http://127.0.0.1/github-issue-client` from your browser

## License
Github Issue Client is open-source software licensed under the [MIT license](https://github.com/mdandidarmawan/github-issue-client/blob/master/LICENSE.md).

## Contributing

Thank you for considering contributing to this repository! Simply fork this repo and pull your request! :)
