@company
Feature: Employees
  In order to see a companies employees
  As a user/employee/company
  I need to be able to se a collection of the companies employees

  Scenario: See all employees
    Given There is a registered user named "Matthis" with employer "TestCompany"
    When User "Matthis" adds company "TestCompany" as my current employer with position "Web developer" and period "2014-12-31 12:00:00" to "2015-03-01 12:00:00"
    Then User "Matthis" should be an employee in company "TestCompany"