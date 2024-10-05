<?php

namespace App\Http\Controllers;

use App\Services\IDGeneratorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\SequentialIdNumber;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Barangay;
use Inertia\Inertia;

class MembersController extends Controller
{
    protected $idGenerator;

    public function __construct(IDGeneratorService $idGenerator)
    {
        $this->idGenerator = $idGenerator;
    }
    
    public function getRole() {
        return Auth::user()->role == 1 ? 'admin' : 'moderator';
    }

    public function index($sendNotif = false) {
        $filter = request()->all();
        $query = Member::query();
        $sendNotif = false; // Initialize sendNotif here

        if (!empty($filter['name'])) {
            $query->where(function($q) use ($filter) {
                $q->where('last_name', 'like', '%' . $filter['name'] . '%')
                  ->orWhere('first_name', 'like', '%' . $filter['name'] . '%');
            });
            $members = $query->orderBy('last_name', 'ASC')->get();
            return Inertia::render('Members/Index', [
                'scmembers' => $members,
                'searchTerm' => $filter['name'] ?? '',
                'userRole' => $this->getRole()
            ]);
        } else {
            $members = $query->orderBy('last_name', 'ASC')->take(5)->get();
            // $sendNotif = $this->save($sendNotif); // Call save() and capture its return value
            // Log::info('notiffffffffffffffffffffffffffff ', $this->save($sendNotif));

            return Inertia::render('Members/Index', [
                'scmembers' => $members,
                'userRole' => $this->getRole(),
                // 'notif' => 'true'
            ]);
        }
    }
    
    public function save(Request $request)
    {
        $sendNotif = false;
        Log::info('==========================');
        Log::info('Member Data:', $request->all());

        if ($request->id) {
            $member = Member::find($request->id);
            if ($member) {
                $member->first_name = $request->first_name;
                $member->middle_name = $request->middle_name;
                $member->last_name = $request->last_name;
                $member->date_of_birth = $request->date_of_birth;
                $member->gender = $request->gender;
                $member->text_address = $request->postal_code;
                $member->brgy = $request->barangay;
                $member->city = $request->city;
                $member->province = $request->province;
                $member->postal_code = $request->postal_code;
                $member->phone_number = $request->phone_number;
                $member->email = $request->email;

                if ($member->save()) {
                    return to_route($this->getRole() . '.members.list', ['message' => 'Member updated successfully.']);
                }

                $sendNotif = false;
            }
        } else {
            $member = new Member();
            $member->senior_citizen_id_no = $this->idGenerator->generateIDNo();
            $member->first_name = $request->first_name;
            $member->middle_name = $request->middle_name;
            $member->last_name = $request->last_name;
            $member->date_of_birth = $request->date_of_birth;
            $member->gender = $request->gender;
            $member->text_address = $request->postal_code;
            $member->brgy = $request->barangay;
            $member->city = $request->city;
            $member->province = $request->province;
            $member->postal_code = $request->postal_code;
            $member->phone_number = $request->phone_number;
            $member->email = $request->email;

            if ($member->save()) {
                $newUsedIDno = new SequentialIdNumber();
                $newUsedIDno->id_no_used = $member->senior_citizen_id_no;
                $newUsedIDno->status = 1;
                
                if ($newUsedIDno->save()) {
                    return to_route($this->getRole() . '.members.list', [
                        'status' => 'success',
                        'message' => 'Member enrolled successfully!'
                    ]);
                }
                $sendNotif = true; // Set notification flag
            }
        }
    }

    public function enroll()
    {
        $barangays = Barangay::pluck('name', 'id');
        return Inertia::render('Members/Enroll', [
            'barangays' => $barangays,
            'userRole' => $this->getRole()
        ]);
    }
}
