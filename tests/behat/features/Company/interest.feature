@company
Feature: Interest
  In order to get new employees
  As a company
  I need to be able to show interest in users

  Scenario: Show interest in user
    Given There is a company named "TestCompany"
    When Company "TestCompany" shows interest in user "Matthis"
    Then Company "TestCompany" should be able to find user "Matthis" in their interested by users list
    And User should be able to find company "TestCompany" as an interested company