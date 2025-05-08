<?php

namespace App\Http\Controllers;

use App\Jobs\RegisterUserActivity;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Department;
use App\Models\Document;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        /*$documents = Document::with(['category:id,name', 'status:id,name'])->get();
        return Inertia::render('Documents/DocumentList', [
            'documents' => $documents,
        ]);*/

        $statusName = $request->query('status'); // Recibir el nombre del estado desde Vue

        // Si se proporciona un estado, obtener su ID
        $statusId = null;
        if ($statusName) {
            $status = Status::where('name', $statusName)->first();
            $statusId = $status ? $status->id : null;
        }

        // Filtrar documentos por status_id si se proporciona
        $documents = Document::with('status')
            ->when($statusId, function ($query, $statusId) {
                return $query->where('status_id', $statusId);
            })
            ->paginate(5);

        // Obtener los estados disponibles
        $statuses = Status::all(['id', 'name']);

        return Inertia::render('Documents/DocumentList', [
            'documents' => $documents,
            'statuses' => $statuses,
            'filters' => [
                'status' => $statusName
            ]
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $categories = Category::all();
        $statuses = Status::all();
        $departments = Department::all();
        return Inertia::render('Documents/CreateDocument', [
            'categories' => $categories,
            'statuses' => $statuses,
            'departments' => $departments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'category' => 'required|integer',
            'status' => 'required|integer',
            'source_department' => 'required|integer',
            'destination_department' => 'nullable|integer',
            'issue_date' => 'required|date',
            'receivedDate' => 'nullable|date',
            'description' => 'nullable|string',
            'priority' => 'nullable|integer',
          //  'isPublic' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $document = new Document();
        $document->title = $request->input('title');
        $document->reference_number = $request->input('reference_number');
        $document->category_id = $request->input('category');
        $document->status_id = $request->input('status');
        $document->source_department = $request->input('source_department');
        $document->destination_department = $request->input('destination_department');
        $document->issue_date = $request->input('issue_date');
        $document->received_date = $request->input('receivedDate');
        $document->created_by = auth()->id();
        $document->description = $request->input('description');
        $document->priority = $request->input('priority');
        //$document->is_public = $request->input('isPublic');
        $document->save();

        /*RegisterUserActivity::dispatch(
            auth()->id(),
            optional(auth()->user())->name,
            'store',
            'document',
            $document->id,
            $document->title,
            [],
            "el documento {$document->title} fue creado por "
        );*/

        return redirect()->route('documents.index')->with('success', 'Documento creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $document->load(['category:id,name', 'status:id,name', 'user:id,name', 'department:id,name']);
        $comment = Comment::with(['user:id,name', 'document', 'replies'])->where('document_id', $document->id)->get();


        return Inertia::render('Documents/ViewDocument', [
            'document' => $document,
            'comments' => $comment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $categories = Category::all();
        $statuses = Status::all();
        $departments = Department::all();
        return Inertia::render('Documents/EditDocument', [
            'document' => $document,
            'categories' => $categories,
            'statuses' => $statuses,
            'departments' => $departments,
            'priority' => $document->priority,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'category' => 'required|integer',
            'status' => 'required|integer',
            'source_department' => 'required|integer',
            'destination_department' => 'nullable|integer',
            'issue_date' => 'required|date',
            'receivedDate' => 'nullable|date',
            'description' => 'nullable|string',
            'priority' => 'nullable|integer',
            //'isPublic' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $document->title = $request->input('title');
        $document->reference_number = $request->input('reference_number');
        $document->category_id = $request->input('category');
        $document->status_id = $request->input('status');
        $document->source_department = $request->input('source_department');
        $document->destination_department = $request->input('destination_department');
        $document->issue_date = $request->input('issue_date');
        $document->received_date = $request->input('receivedDate');
        $document->description = $request->input('description');
        $document->priority = $request->input('priority');
        // $document->is_public = $request->input('isPublic');
        $document->save();

        $changes = $document->getChanges();
        $changes += isset($changes['category_id']) ? ['categoría' => $document->category->name] : [];
        $changes += isset($changes['status_id']) ? ['estado' => $document->status->name] : [];


        return Redirect::route('documents.show', $document->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        /*RegisterUserActivity::dispatch(
            auth()->id(),
            optional(auth()->user())->name,
            'delete',
            'document',
            $document->id,
            $document->title,
            [],
            "El documento {$document->title} fue eliminado por "
        );*/

        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Documento eliminado con éxito.');
    }

    /**
     * Search documents by filters.
     */
    public function filters(Request $request)
    {
        $filters = $request->only(['status', 'category', 'start_date', 'end_date']);

        $documents = Document::query()
            ->when($filters['status'] ?? null, function ($query, $status) {
                $query->where('status_id', $status);
            })
            ->when($filters['category'] ?? null, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($filters['start_date'] ?? null, function ($query, $start_date) use ($filters) {
                $query->whereBetween('created_at', [$start_date, $filters['end_date']]);
            })
            ->with('category', 'status')
            ->get();

        return Inertia::render('Documents/FilterDocuments', [
            'documents' => $documents,
            'categories' => Category::select('id', 'name')->get(),
            'statuses' => Status::select('id', 'name')->get(),
            'filters' => $filters,
        ]);
    }

    /**
     * Search documents by title.
     */
    public function search(Request $request): Response
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $searchTerm = $request->input('query');

        $documents = Document::where('title', 'like', '%' . $searchTerm . '%')->get();

        if ($documents->isEmpty()) {
            return Inertia::render('Documents/SearchResults', [
                'documentsSearch' => [],
                'message' => 'No se encontraron resultados.',
                'searchTerm' => $searchTerm,
            ]);
        }

        return Inertia::render('Documents/SearchResults', [
            'documentsSearch' => $documents,
            'searchTerm' => $searchTerm,
        ]);
    }

    /**
     * Display the control panel.
     */
    public function controlPanel(): Response
    {
        $statusCounts = Document::select('status_id', DB::raw('count(*) as total'))
            ->with('status:id,name')
            ->groupBy('status_id')
            ->get();
        $totalDocuments = $statusCounts->sum('total');
        $users = User::orderBy('created_at', 'desc')->take(10)->get();
        $notifications = DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->take(9)
            ->get();
        return Inertia::render('Dashboard', [
            'statusCounts' => $statusCounts,
            'users' => $users,
            'notifications' => $notifications,
            'totalDocuments' => $totalDocuments,
        ]);
    }
}
        /*try {
            $initialDocuments = Document::orderBy('created_at', 'desc')->take(15)->get();

            $query = Document::query();

            if (request()->has('status')) {
                $query->where('status_id', request('status'));
            }

            if (request()->has('category')) {
                $query->where('category_id', request('category'));
            }

            if (request()->has('receivedDate_start') &&
                request('receivedDate_finish')) {
                $query->whereBetween('received_date', [
                    request('receivedDate_start'),
                    request('receivedDate_finish')]);
            }

            if (request()->has('createdDate_start') &&
                request('createdDate_finish')) {
                $query->whereBetween('created_at', [
                    request('createdDate_start'),
                    request('createdDate_finish')]);
            }

            $documents = $query->get();

            return Inertia::render('Documents/Queries', [
                'initialDocuments' => $initialDocuments,
                'documents' => $documents,
                'filters' => request()->only(['status', 'category'])
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al consultar los documentos.'])->withInput();
        }*/
