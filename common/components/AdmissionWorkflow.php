<?php
    namespace common\components;
    use common\components\Roles;

    class AdmissionWorkflow {
		const STATE_PENDING = 0;
        const STATE_DRAFT = 1;
        const STATE_SUBMITTED_FOR_REVIEW = 2;
        const STATE_SRM_CHANGE_REQUEST = 3;
        const STATE_SRM_REJECTED = 4;   
        const STATE_SUBMITTED_TO_UNIVERSITY = 5;
        const STATE_UNIVERSITY_REJECTED = 6;
        const STATE_UNIVERSITY_CHANGE_REQUEST = 7;
        const STATE_UNIVERSITY_ACCEPTED = 8;
        const STATE_SHORTLISTED = 9;
        const STATE_SELECTED = 10;
        const STATE_NOT_SELECTED = 11;
        const STATE_ADMITTED = 12;
        const CLOSED = 13;        

       public static function getStateName($id) {
            $map = AdmissionWorkflow::getStates();

            return $map[$id];
        }

         public static function getStates(){
            return [
				AdmissionWorkflow::STATE_PENDING => 'Pending',
                AdmissionWorkflow::STATE_DRAFT => 'Draft',
                AdmissionWorkflow::STATE_SUBMITTED_FOR_REVIEW => 'Submitted for Review',
                AdmissionWorkflow::STATE_SRM_CHANGE_REQUEST => 'SRM Change Request',                
                AdmissionWorkflow::STATE_SRM_REJECTED => 'SRM Rejected',                
                AdmissionWorkflow::STATE_SUBMITTED_TO_UNIVERSITY => 'Submitted to University',
                AdmissionWorkflow::STATE_UNIVERSITY_REJECTED => 'Univeristy Rejected',
                AdmissionWorkflow::STATE_UNIVERSITY_CHANGE_REQUEST => 'University Change Request',
                AdmissionWorkflow::STATE_UNIVERSITY_ACCEPTED => 'Accepted',
                AdmissionWorkflow::STATE_SHORTLISTED => 'Shortlisted',
                AdmissionWorkflow::STATE_SELECTED => 'Selected',
                AdmissionWorkflow::STATE_NOT_SELECTED => 'Not Selected',
                AdmissionWorkflow::STATE_ADMITTED => 'Admitted',
                AdmissionWorkflow::CLOSED => 'Closed'
            ];
        }


        public static function getStateDetails($id) {
            $state_action_role_map = [
                AdmissionWorkflow::STATE_DRAFT => [
                    'actions' => ['Submit'],
                    'roles' => [ Roles::ROLE_STUDENT ],
                    'notifications' => [
                        'Submit' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been submitted to your Counselor/Consultant for review. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ]
                        ]                        
                    ],
                    'messages' => [ 
                        'Submit' => [
                            Roles::ROLE_STUDENT => [
                            'message' => 'Your application has been submitted to your Counselor/Consultant for review. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Submit' => AdmissionWorkflow::STATE_SUBMITTED_FOR_REVIEW
                    ]
                ],
                AdmissionWorkflow::STATE_SUBMITTED_FOR_REVIEW => [
                    'actions' => ['Approve', 'Reject', 'Request Change'],
                    'roles' => [ Roles::ROLE_SRM, Roles::ROLE_CONSULTANT, Roles::ROLE_ASSOCIATE_CONSULTANT ],
                    'notifications' => [
                        'Approve' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been approved by your Counselor/Consultant and has been submitted to university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Application submitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Application submitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Application submitted to university. Click on this link to open application.'
                            ]
                        ],
                        'Reject' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been rejected by your Counselor/Consultant and has been submitted to university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Application rejcted. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Application rejected. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Application rejected. Click on this link to open application.'
                            ]
                        ],
                        'Request Change' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'You have a change request in your application by your Counselor/Consultant. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Change request submitted to student. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Change request submitted to student. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Change request submitted to student. Click on this link to open application.'
                            ]
                        ]                        
                    ],
                    'messages' => [ 
                        'Approve' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been approved by your Counselor/Consultant and has been submitted to university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Application submitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Application submitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Application submitted to university. Click on this link to open application.'
                            ]
                        ],
                        'Reject' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been rejected by your Counselor/Consultant and has been submitted to university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Application rejcted. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Application rejected. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Application rejected. Click on this link to open application.'
                            ]
                        ],
                        'Request Change' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'You have a change request in your application by your Counselor/Consultant. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Change request submitted to student. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Change request submitted to student. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Change request submitted to student. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Approve' => AdmissionWorkflow::STATE_SUBMITTED_TO_UNIVERSITY,
                        'Reject' => AdmissionWorkflow::STATE_SRM_REJECTED,               
                        'Request Change' => AdmissionWorkflow::STATE_SRM_CHANGE_REQUEST,
                    ]
                ],                
                AdmissionWorkflow::STATE_SRM_CHANGE_REQUEST => [
                    'actions' => ['Submit'],
                    'roles' => [ Roles::ROLE_STUDENT ],
                    'notifications' => [
                        'Submit' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been submitted to your Counselor/Consultant for review. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ]
                        ]                        
                    ],
                    'messages' => [ 
                        'Submit' => [
                            Roles::ROLE_STUDENT => [
                            'message' => 'Your application has been submitted to your Counselor/Consultant for review. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Submit' => AdmissionWorkflow::STATE_SUBMITTED_FOR_REVIEW
                    ]
                ],
                AdmissionWorkflow::STATE_SUBMITTED_TO_UNIVERSITY => [
                    'actions' => ['Approve', 'Reject', 'Request Change'],
                    'roles' => [ Roles::ROLE_UNIVERSITY ],
                    'notifications' => [
                        'Approve' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been approved by university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application approved by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application approved by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application approved by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student application approved. Click on this link to open application.'
                            ]
                        ],
                        'Reject' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been rejected by university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student application rejected. Click on this link to open application.'
                            ]
                        ],
                        'Request Change' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'You have a change request in your application by your university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Change requested by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Change requested by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Change requested by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Change requested submitted to student. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'messages' => [ 
                        'Approve' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been approved by university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application approved by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application approved by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application approved by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student application approved. Click on this link to open application.'
                            ]
                        ],
                        'Reject' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been rejected by university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student application rejected. Click on this link to open application.'
                            ]
                        ],
                        'Request Change' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'You have a change request in your application by your university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Change requested by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Change requested by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Change requested by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Change requested submitted to student. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Approve' => AdmissionWorkflow::STATE_UNIVERSITY_ACCEPTED,
                        'Reject' => AdmissionWorkflow::STATE_UNIVERSITY_REJECTED,
                        'Request Change' => AdmissionWorkflow::STATE_UNIVERSITY_CHANGE_REQUEST,
                    ]
                ],
                AdmissionWorkflow::STATE_UNIVERSITY_ACCEPTED => [
                    'actions' => ['Shortlist', 'Reject'],
                    'roles' => [ Roles::ROLE_UNIVERSITY ],
                    'notifications' => [
                        'Shortlist' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been shortlisted by university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application shortlisted by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application shortlisted by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application shortlisted by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student application shortlisted. Click on this link to open application.'
                            ]
                        ],
                        'Reject' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been rejected by university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student application rejected. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'messages' => [ 
                        'Shortlist' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been shortlisted by university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application shortlisted by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application shortlisted by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application shortlisted by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student application shortlisted. Click on this link to open application.'
                            ]
                        ],
                        'Reject' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been rejected by university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application rejected by university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student application rejected. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Shortlist' => AdmissionWorkflow::STATE_SHORTLISTED,
                        'Reject' => AdmissionWorkflow::STATE_UNIVERSITY_REJECTED,
                    ]
                ],                
                AdmissionWorkflow::STATE_UNIVERSITY_REJECTED => [
                    'actions' => ['Close'],
                    'roles' => [ Roles::ROLE_STUDENT ],
                    'notifications' => [
                        'Close' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been closed. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'messages' => [ 
                        'Close' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been closed. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Close' => AdmissionWorkflow::CLOSED
                    ]
                ],
                AdmissionWorkflow::STATE_UNIVERSITY_CHANGE_REQUEST => [
                    'actions' => ['Submit'],
                    'roles' => [ Roles::ROLE_STUDENT ],
                    'notifications' => [
                        'Submit' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been submitted to your Counselor/Consultant for review. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ]
                        ]                        
                    ],
                    'messages' => [ 
                        'Submit' => [
                            Roles::ROLE_STUDENT => [
                            'message' => 'Your application has been submitted to your Counselor/Consultant for review. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'You have recieved a request to review an application. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Submit' => AdmissionWorkflow::STATE_SUBMITTED_FOR_REVIEW
                    ]
                ],
                AdmissionWorkflow::STATE_SHORTLISTED => [
                    'actions' => ['Admit', 'Do not Admit'],
                    'roles' => [ Roles::ROLE_UNIVERSITY ],
                    'notifications' => [
                        'Admit' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your have been admitted to university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student admitted. Click on this link to open application.'
                            ]
                        ],
                        'Do not Admit' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your have not been admitted to university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student not admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student not admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student not admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student not admitted. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'messages' => [ 
                        'Admit' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your have been admitted to university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student admitted. Click on this link to open application.'
                            ]
                        ],
                        'Do not Admit' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your have not been admitted to university. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student not admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student not admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student not admitted to university. Click on this link to open application.'
                            ],
                            Roles::ROLE_UNIVERSITY => [
                                'message' => 'Student not admitted. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Admit' => AdmissionWorkflow::STATE_ADMITTED,
                        'Do not Admit' => AdmissionWorkflow::STATE_NOT_SELECTED,
                    ]
                ],
                AdmissionWorkflow::STATE_NOT_SELECTED => [
                    'actions' => ['Close'],
                    'roles' => [ Roles::ROLE_STUDENT ],
                    'notifications' => [
                        'Close' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been closed. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'messages' => [ 
                        'Close' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been closed. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Close' => AdmissionWorkflow::CLOSED,
                    ]
                ],
                AdmissionWorkflow::STATE_ADMITTED => [
                    'actions' => ['Close'],
                    'roles' => [ Roles::ROLE_STUDENT ],
                    'notifications' => [
                        'Close' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been closed. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'messages' => [ 
                        'Close' => [
                            Roles::ROLE_STUDENT => [
                                'message' => 'Your application has been closed. Click on this link to view your application',                             
                            ],
                            Roles::ROLE_SRM => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ],
                            Roles::ROLE_ASSOCIATE_CONSULTANT => [
                                'message' => 'Student application closed. Click on this link to open application.'
                            ]
                        ]
                    ],
                    'next' => [
                        'Close' => AdmissionWorkflow::CLOSED
                    ]
                ]
            ];

            if(isset($state_action_role_map[$id])) {
                return $state_action_role_map[$id];
            }
            return false;
        }
    }
?>