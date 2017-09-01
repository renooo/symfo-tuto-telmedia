Feature: Artist creation
    Background:
        Given I am on "/login"
        And I fill in "_username" with "toto"
        And I fill in "_password" with "azerty"
        And I press "Connexion"

    #Scenario: Artist creation fails with bad data
        #todo

    @javascript
    Scenario: Artist creation suceeds with proper data
        Given I am on "/artist/create"
        Then I should see "totot tutu titi"
