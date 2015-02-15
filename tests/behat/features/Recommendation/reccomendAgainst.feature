@recommendation
Feature: Recommend against company
  In order to warn other users of bad companies
  As an employee
  I need to be able to not recommend a company

  Background:
    Given There is a registered user named "Matthis"
    And There is a company named "Acme"

  Scenario: Un recommend
    Given User "User" is employed at company "Acme"
    When User "Matthis" recommends against company "Acme"
    Then Company "Acme" should have a recommendation by user "Matthis" and type "negative"

  Scenario: Un recommend with reason
    Given User "User" is employed at company "Acme"
    When User "Matthis" recommends against company "Acme" with reason "Reason to recommend against"
    Then Company "Acme" should have a recommendation by user "Matthis" and type "negative" and reason "Reason to recommend against"

  Scenario: Un recommend company not employed or has been employed at
    When User "Matthis" recommends company "Acme"
    Then Company "Acme" should not have a recommendation from user "Matthis"
