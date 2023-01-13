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

## Notes

1. It is recommended to change the following settings within your vBulletin Installation.
  - Settings -> Human Verification - Disable this functionality.
  - Settings -> Options -> Message Posting and Editing Options - Disable Floodcheck.


2. If your list of channels does not match the array at the top of createPosts.php then you must update this array. It is the comma separated list within the [] of line #3. Default Line:

>```$channels = [16,17,18,20,21,22,24,25,26];```

## Coming Soon

- [ ] The ability to create topics with other content types.
- [ ] Command line parameters to control amount of items created.
- [ ] Menu system that accepts parameters.


---

## License

vbFaker is licensed under the MIT License.

A valid vBulletin license is required to use vbFaker. This can be obtained at [vBulletin.com](https://www.vbulletin.com)
