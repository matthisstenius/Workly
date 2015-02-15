@company
Feature: Endorse company quality
  In order to validate that a company lives after it's qualities
  As a user
  I need to be able to endorse a company's quality

  Scenario: Endorse quality
    Given There is a registered user named "Matthis"
    And There is a company named "Acme"
    And There is a quality called "Flexible hours"
    And Company "Acme" has quality "Flexible hours"
    When I endorse company "Acme" for quality "Flexible hours"
    Then Company "Acme" should have an endorsement for quality "Flexible hours" by user "Matthis"
