<?php 
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Jobs\ContactImportJob;

class ContactController extends Controller
{
    // Display contacts
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    // Show create form
    public function create()
    {
        return view('contacts.create');
    }

    // Store a contact
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:contacts,phone', // Ensure phone is unique
        ]);
        Contact::create($validated);
        return redirect()->route('contacts.index');
    }

    // Show edit form
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    // Update a contact
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:contacts,phone,' . $id, // Allow current phone
        ]);
        $contact = Contact::findOrFail($id);
        $contact->update($validated);
        return redirect()->route('contacts.index');
    }

    // Delete a contact
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('contacts.index');
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact'));
    }

    public function importForm()
    {
        return view('contacts.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimes:xml|max:10240',
        ], [
            'xml_file.required' => 'Please upload an XML file.',
            'xml_file.mimes' => 'Only XML files are allowed.',
            'xml_file.max' => 'The XML file must be smaller than 10MB.',
        ]);

        try {
            $path = $request->file('xml_file')->storeAs('imports', 'contacts.xml');
            ContactImportJob::dispatch($path);
            return redirect()->route('contacts.index')->with('status', 'Contacts are being imported!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['xml_file' => 'An error occurred while processing the file. Please try again.']);
        }
    }


}
