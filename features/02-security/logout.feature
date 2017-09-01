Feature: User logout

    Scenario Outline: Logout link ends user's session
        Given I am on "/login"
        And I fill in "_username" with "<user>"
        And I fill in "_password" with "<pass>"
        And I press "Connexion"
        When I am on "/artists"
        And I follow "Déconnexion"
        And I am on "/artists"
        Then I should not see "Déconnexion"
        Examples:
            | user | pass   |
            | toto | azerty |
            | titi | azerty |