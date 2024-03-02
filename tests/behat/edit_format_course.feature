@format @format_redirected @javascript
Feature: Edit format course to Redirected format
  In order to set the format course to Redirected course
  As a teacher
  I need to edit the course settings and see the dropdown type activity

  Scenario: Edit a format course as a teacher
    Given the following "users" exist:
      | username | firstname | lastname | email |
      | teacher1 | Teacher | 1 | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | summary | format |
      | Course 1 | C1 | <p>Course summary</p> | topics |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | C1 | editingteacher |
    And I log in as "teacher1"
    When I am on "Course 1" course homepage with editing mode on
    And I navigate to "Settings" in current page administration
    And I expand all fieldsets
    And I set the following fields to these values:
      | Course full name  | My first course |
      | Course short name | myfirstcourse |
      | Format | Redirected format |
    And I press "Save and display"
    Then I should see "This course is configured as"
