@company
Feature: Qualities
  In order to show potential employees our qualities
  As a company
  We need to be able to show our qualities

  Scenario: Add quality
    Given There is a company named "Acme"
    And There is a quality called "Flexible hours"
    When Quality "Flexible hours" is added to company "Acme"
    Then Company "Acme" should have quality "Flexible hours"
