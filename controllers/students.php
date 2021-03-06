<?php
class studentsController extends BaseController {
    public function __construct () {
    }

    function manage() {
        if( ! ( new UserMdl() )->hasAccessTo( EnumUserRoleType::admin ) ) {
            ( new ErrorController() )->Error403();
            return;
        }
        $this->g_can_edit = ( new UserMdl() )->hasAccessTo( EnumUserRoleType::admin );
        $mgr = new studentMgr();
        $this->render( "manage", $mgr->getRecordPageTitle() );
    }

    function list( $search_text = "" ) {
        if( ! ( new UserMdl() )->hasAccessTo( EnumUserRoleType::admin ) ) {
            echo ( new GeneralDisplay() )->deterFeedback( false, "", UNAUTHORISED_MESSAGE );
            return;
        }
        $this->g_can_edit = ( new UserMdl() )->hasAccessTo( EnumUserRoleType::admin );
        $model = new StudentMgr( $search_text );
        $this->g_layout = null;
        $this->g_form_fields = ( new StudentMdl() )->getFields();
        $this->g_records = $model->getRecords();
        $this->render("list");
    }

    function unlinkedlist( $search_text ) {
        if( ! ( new UserMdl() )->hasAccessTo( EnumUserRoleType::admin ) ) {
            echo ( new GeneralDisplay() )->deterFeedback( false, "", UNAUTHORISED_MESSAGE );
            return;
        }
        $this->g_layout = null;
        $this->g_records = LookupData::getUnlinkedstudentList( $search_text );
        $this->render("unlinkedlist");
    }
}