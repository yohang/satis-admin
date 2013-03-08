Feature: Read Satis configuration file
    In order to see satis configuration options
    As an administrator
    I nead to be able to read and display configuration

    Scenario: Display homepage
        Given I am on the homepage
        Then I should see "Test repository"

    Scenario: Display Repositories
        Given I am on the homepage
        Then The following repositories are visible:
            | type | url                                        |
            | vcs  | https://github.com/yohang/CalendR.git      |
            | vcs  | https://github.com/yohang/Finite.git       |
            | vcs  | https://github.com/frequence-web/OOSSH.git |
