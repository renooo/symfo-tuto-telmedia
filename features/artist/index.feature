Feature: Artist Listing

    Scenario: Artists are sorted alphabetically
        Given I am on "/artists"
        Then I should see "349 artistes en base"
