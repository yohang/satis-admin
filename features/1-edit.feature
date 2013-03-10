Feature: Edit Satis configuration file
    In order to edit satis configuration options
    As an administrator
    I nead to be able to change and write configuration

    Scenario: Display Edit form
        Given I am on the homepage
        When I follow "Edit configuration"
        Then I should see "Edit configuration"

    Scenario: Fill the form with invalid data
        Given I am on "/edit"
        And the "Name" field should contain "Test repository"
        And the "Homepage" field should contain "https://github.com/yohang"
        When I fill the form with
            | field    | value                  |
            | Name     |                        |
            | Homepage | http://yohan.giarel.li |
        And I press "Save"
        Then I should see "This value should not be blank."

    Scenario: Fill the form with valid data
        Given I am on "/edit"
        And the "Name" field should contain "Test repository"
        And the "Homepage" field should contain "https://github.com/yohang"
        When I fill the form with
            | field    | value                  |
            | Name     | Satis admin            |
            | Homepage | http://yohan.giarel.li |
        And I press "Save"
        Then I should see "Satis admin"
