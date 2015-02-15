@user
Feature: Register an account
  In order to register an account
  As a user
  I need to be able to register for an account

  Scenario: Register account with valid name, email and password
    When I register with name "Matthis" and surname "Stenius" and email "test@test.com" and password "password"
    Then There should be a registered user with name "Matthis" and surname "Stenius" and email "test@test.com"

  Scenario: Register account with unvalid email
    When I register with name "Matthis" and surname "Stenius" and email "invalidemail" and password "password"
    Then There should not be a registered user