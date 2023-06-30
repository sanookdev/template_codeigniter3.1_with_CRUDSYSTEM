<?
class User_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkDuplicate($username){
        $this->db->select('*');
        $this->db->where('username',$username);
        $query = $this->db->get('user',1);
        return $query->row();
    }

    public function fetchAll(){
        $this->db->select('*');
        $query = $this->db->get('user');
        return $query->result();
    }
    public function create($data){
        $data['username'] = strtoupper($data['username']);
        $data['password'] = md5(md5($data['password']));
        $data['created_by'] = $this->session->userdata['userName'];
        if($this->db->insert('user',$data)){
            return 1;
        }else{
            return 0;
        }
    }
    public function updateStatus($username,$data){
        $this->db->where('username',$username);
        if($this->db->update('user',$data)){
            return 1;
        }else{
            return 0;
        }
    }

    public function updatePassword($username,$data){
        $this->db->where('username',$username);
        if($this->db->update('user',$data)){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function deleteUser($username){
        $this->db->where('username',$username);
        if($this->db->delete('user')){
            return 1;
        }else{
            return 0;
        }
    }

}
?>