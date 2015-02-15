@user
Feature: Employment
  In order to show my current employment status
  As a user
  I need to be able to add a company as my employer

  Scenario: Add employer
    Given There is a registered user named "Matthis"
    And There is a company named "Acme"
    When I add company "Acme" as my current employer with position "Web developer" and period "2014-12-31 12:00:00" to "2015-03-01 12:00:00"
    Then company "Acme" should be my current employer with position "Web developer"