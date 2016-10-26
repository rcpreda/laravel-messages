<?php

namespace App\Http\Controllers;

use App\Http\Repositories\MessageRepositoryInterface;
use DB;
use Redirect;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * @var MessageRepositoryInterface
     */
    private $messageRepository;

    /**
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->middleware('auth');
        $this->messageRepository = $messageRepository;
    }

    public function index()
    {
        $messages = $this->messageRepository->getAll();
        //var_dump($messages);die;
        return view('message.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $users = User::excludeAuth()->toOptionArray();
        } catch(\Exception $e) {
            //Flash::warning($e->getMessage());
            return Redirect::route('home.index');
        }

        return view('message.create', compact('users'));
    }

    /**
     * @param Requests\MessageRequest $request
     * @return mixed
     */
    public function store(Requests\MessageRequest $request)
    {
        try {
            $this->messageRepository->saveEntity($request->all());
            //Flash::success('Message successfully sent!');
        } catch (\Exception $e) {
            //Flash::error($e->getMessage());
        }
        return Redirect::route('message.index');

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeDetails(Request $request)
    {
        try {
            $this->messageRepository->saveEntityDetails($request->all());
            //Flash::success('Message successfully sent!');
        } catch (\Exception $e) {
            var_dump($e->getMessage());die;
            //Flash::error($e->getMessage());
        }
        return Redirect::route('message.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        try {
            $messages = $this->messageRepository->getMessagesById($id);
            //var_dump($messages->last());die;
        } catch(\Exception $e) {
            var_dump($e->getMessage());die;
            //Flash::error("Car model with id {$id} couldn't been found!");
            return Redirect::route('message.index');
        }
        return view('message.view', compact('messages'));

    }

    /**
     * @param Request $request
     */
    public function seen(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $this->messageRepository->updateVisibility($data['messageId']);
        }
    }
}
