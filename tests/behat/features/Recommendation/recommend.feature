@recommendation
Feature: Recommend company
  In order to show others users that a company is good
  As en employee
  I need to be able to recommend a company

  Background:
    Given There is a registered user named "Matthis"
    And There is a company named "Acme"

  Scenario: Recommend
    Given User "Matthis" is employed at company "Acme"
    When User "Matthis" recommends company "Acme"
    Then Company "Acme" should have a recommendation from user "Matthis"

  Scenario: Recommend with reason
    Given User "Matthis" is employed at company "Acme"
    When User "Matthis" recommends company "Acme" with reason "A reason why i recommend this company"
    Then Company "Acme" should have a recommendation from user "Matthis" with reason "A reason why i recommend this company"

  Scenario: Recommend company not employed or has been employed at
    When User "Matthis" recommends company "Acme"
    Then Company "Acme" should not have a recommendation from user "Matthis"
