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
        When I fill the form with
            | field    | value                  |
            | Name     |                        |
            | Homepage | http://yohan.giarel.li |
        And I press "Save"
        Then I should see "This value should not be blank."
