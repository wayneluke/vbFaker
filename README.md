# vbFaker
Creates fake data in a vBulletin 5 installation. In order to do this, it utilizes the vBulletin API.

## Installing

To install:

1. [Install Composer](https://getcomposer.org/download/).
1. Install vBulletin 5 into a web accessible directory.
    - Your vBulletin installation must have a user with the userid of 1.
1. Download this repository to your local drive.
1. Copy the vBFaker directory into your /core/ directory.
1. Open a command line window (cmd, wsl, bash, zsh, etc...)
1. From the command line change to the vbFaker directory.
    - `cd /vbulletin/core/vbFaker`
1. Run `composer update`.

### Dependencies

- [Composer](https://getcomposer.org/) is required for this project.
- vBulletin
- [fzaninotto/faker](https://github.com/fzaninotto/Faker) - Random data generator.

All dependencies except Composer and vBulletin will be automatically installed by running `composer update`.

## Usage

Each task is run from the commandline of the vbFaker directory.

Ex: `php createUsers.php`

## Tasks

Each task is its own file within the vbFaker directory. Please read the comments at the top of the file for additional instructions required for each task.

- createUsers.php: Creates a random number of users between specified min and max values. These users have:
  - username - combination of first name and last name from several locales. (Can contain UTF-8)
  - email addresses - firstname.lastname@domain.com (UTF-8 characters are stripped via iconv)
  - randomized passwords
  - random IP addresses.
  - Users are placed in random usergroups
- createPosts.php: Creates a random number of topics and replies in Forum Channels from a specified list.
  - Each Topic starter has a random length of Lorem Ipsum text.
  - Each Topic will have a random number of replies between 0 and 100.
  - Each Reply will reference the Topic ID and have a random length of Lorem Ipsum text.

## Coming Soon

- IPv6 Addresses for users and posts.
- The ability to create topics with other content types.
- Create posts with different users. Currently all posts are created by user id #1.
- Command line parameters to control amount of items created.
- Menu system that accepts parameters.

## Reference Database

A reference database containing over 30,000 users and over 2 Million Posts created with vbFaker can be found at [GitHub]()

---

## License

vbFaker is licensed under the MIT License.

A valid vBulletin license is required to use vbFaker. This can be obtained at [vBulletin.com](https://www.vbulletin.com)
