Feature: Manage repository collection
    In order to add/remove/edit repositories in the config
    As an administrator
    I need to be able to edit, add and delete lines in the repository collection

    @javascript
    Scenario: Add a repository
        Given I am on "/edit"
        When I follow the Add repository link
        And I fill the last "Type" field with "vcs"
        And I fill the last "Url" field with "https://github.com/yohang/dependency-tools.git"
        And I press "Save"
        Then The following repositories are visible:
            | type | url                                            |
            | vcs  | https://github.com/yohang/CalendR.git          |
            | vcs  | https://github.com/yohang/Finite.git           |
            | vcs  | https://github.com/frequence-web/OOSSH.git     |
            | vcs  | https://github.com/yohang/dependency-tools.git |

    @javascript
    Scenario: Remove a line
        Given I am on "/edit"
        When I follow the last remove repository link
        And I press "Save"
        Then The following repositories are visible:
            | type | url                                            |
            | vcs  | https://github.com/yohang/CalendR.git          |
            | vcs  | https://github.com/yohang/Finite.git           |


