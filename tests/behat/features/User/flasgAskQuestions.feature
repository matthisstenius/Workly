@user
Feature: Flag for question preference
  In order to show if willingness for answering questions about my workplace
  As an employee
  I need to be able to flag if i want to answer questions or not

  Background:
    Given There is a registered user named "Matthis"
    And There is a company named "Acme"
    And User "Matthis" is employed at company "Acme"

  Scenario: Add flag to accept questions
    When User "Matthis" adds flag for accepting questions about company "Acme"
    Then User "Matthis" should be flagged for accepting questions about company "Acme"

  Scenario: Remove flag for accepting questions
    Given User "Matthis" accepts questions for company "Acme"
    When User "Matthis" removes flag for accepting questions about company "Acme"
    Then User "Matthis" should be flagged to not accept questions about company "Acme"