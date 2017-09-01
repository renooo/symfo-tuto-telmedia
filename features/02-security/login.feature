Feature: User login

    Scenario Outline: Login succeeds with existing user
        Given I am on "/login"
        And I fill in "_username" with "<user>"
        And I fill in "_password" with "<pass>"
        And I press "Connexion"
        When I am on "/artists"
        Then I should see "Déconnexion"
        Examples:
            | user | pass   |
            | toto | azerty |
            | titi | azerty |

    Scenario: Login fails with unknown credentials
