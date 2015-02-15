@user
 Feature: Qualities
   In order to find companies with with qualities i am interested in
   As a user
   I need to be able to have a list of qualities that are interesting to me

  Scenario: Add quality
    Given There is a registered user named "Matthis"
    And There is a quality called "Flexible hours"
    When I add quality "Flexible hours" to my list of qualities that i'm interested in
    Then Quality "Flexible hours" should be in my list of qualities that i'm interested in

  Scenario: Add quality that already exist
    Given There is a registered user named "Matthis"
    And There is a quality called "Flexible hours"
    And User "Matthis" is interested in quality "Flexible hours"
    When I add quality "Flexible hours" to my list of qualities that i'm interested in
    Then Quality "Flexible hours" should not be in my list of qualities that i'm interested in