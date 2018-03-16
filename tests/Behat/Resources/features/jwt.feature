Scenario: Return user when send valid JWT
  Given I have a valid JWT
  When I request GET with JWT to "/session/user/decode" in the cookie
  Then the response should contain json:
  """
      {
      "user": "user"
      }
  """