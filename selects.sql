Select Invited_User_ID, User.Firstname, User.Lastname
FROM Invitation
WHERE Event_ID = 2
LEFT JOIN User ON
User.User_ID = Invitation.Invited_User_ID;
