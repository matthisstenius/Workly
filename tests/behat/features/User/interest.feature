@user
Feature: Interest
  In order to show my interest in a company
  As a user
  I need to be able to show interest in that company

  Scenario: Show interest in a company
    Given There is a registered user named "Matthis"
    And There is a company named "Acme"
    When I show interest in company "Acme"
    Then I should be able to find company "Acme" in my interested by companies list