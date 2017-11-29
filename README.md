Invitation System.
=================

Please run:
1. composer install
2. php bin/console server:run

API calls:

/api/v1/invite/{senderId}/{receiverId} - invite
/api/v1/cancel/{senderId}/{invitationId} - cancel invitation
/api/v1/accept/{receiverId}/{invitationId} - accept invitation
/api/v1/decline/{receiverId}/{invitationId} - decline invitation
/api/v1/sentList/{senderId} - all sent invitations
/api/v1/invitedList/{receiverId} - all received invitations