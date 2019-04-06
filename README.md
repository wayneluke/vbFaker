# vbFaker
Creates fake data in a vBulletin 5 installation.

## Installing

[Composer](https://getcomposer.org/) is required for this project.

To install:

1. Install Composer.
2. Download this repository to your local drive. It expects to be in a subdirectory of vBulletin's /core/ directory.
3. From the command line change the the vbFaker directory.
4. Run `composer update`.

## Tasks

- Creates a random number of users between specified min and max values. These users have:
  - username - combination of first name and last name from several locales.
  - email addresses - firstname.lastname@domain.com
  - randomized passwords
  - random IP addresses.
- Creates a random number of topics and replies in Forum Channels from a specified list.
  - Each Topic starter has a random length of Lorem Ipsum text.
  - Each Topic will have a random number of replies between 1 and 50.
  - Each Reply will reference the Topic ID and have a random length of Lorem Ipsum text.
