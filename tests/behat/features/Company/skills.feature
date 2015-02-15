@company
Feature: Skills
  In order to attract people with relevant skills
  As a company
  We need to be able to show which skills we are looking for

  Scenario: Add skill
    Given There is a company named "TestCompany"
    When Skill "PHP" is added to company "TestCompany"
    Then Skill "PHP" should be in company "TestCompany" wanted skills