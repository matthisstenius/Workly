@user
Feature: Skills
  In order to show which skills i posses
  As a user
  I need to be able to add a skill to my list of skills

  Scenario: Add skill
    Given There is a registered user named "Matthis"
    And There is a skill named "PHP"
    When I add skill "PHP" to my list of skills
    Then There should be a skill named "PHP" in my list of skills