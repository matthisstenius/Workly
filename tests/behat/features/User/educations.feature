@user
Feature: Educations
  In order to show my educations
  As a user
  I need to be able to have a list of educations

  Scenario: Add education to my list of educations
    Given There is a registered user named "Matthis"
    And There is an education with name "Webbprogrammerarprogrammet" and institute "Linneuniversitet"
    When I add education named "Webbprogrammerarprogrammet" to my list of educations
    Then There should be an education named "Webbprogrammerarprogrammet" with institute "Linneuniversitet" in my list of educations