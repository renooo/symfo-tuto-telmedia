Feature: Artist list
    As a music fanatic
    In order to discover new awsome bands
    I must find a list of great artists

    Scenario: Artist list is alphabetically sorted by default
        Given I am on "/artists"
        Then I should see "Liste des artistes"
        Then I should see "!!!" as the 1st artist
        Then I should see "Zwan" as the 349th artist

