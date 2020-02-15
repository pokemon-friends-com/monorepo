Maintainers have the last word to merge or refuse PRs.
All contributions have to pass all CI tests to be merged.
All PRs have to follow the [conventional commits v1.0.x](https://www.conventionalcommits.org/en/v1.0.0-beta.4/)
- Following the conventional commits scopes
    - phpstorm or ide
    - github
    - travis-ci or ci or test or deploy
    - codestyle or lint or phpcs or eslint
    - laradock or docker
    - theme
    - app (application or infrastructure - related to `app/Infrastructure` directory)
    - auth (core domain - laravel imposed domain)
    - oauth (core domain - laravel passport imposed domain)
    - users (domain)
    - files (domain)
    - deps & deps-dev -> reserved to dependabot
    - release & bump -> reserved to maintainers

Read also : [hexagonal architecture by fideloper](https://fideloper.com/hexagonal-architecture)
