<?php

namespace domain\Services;

use App\Models\Project;

class ProjectService
{
    protected $project;

    public function __construct()
    {
        $this->project = new Project();
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        return $this->project->with('customers.addresses')->get();
    }

    /**
     * get
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {
        return $this->project->with('customers.addresses')->find($id);
    }

    public function create($data)
    {
        // Create Project
        $project = Project::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        // Attach Customers
        $customerIds = collect($data['customers'])->pluck('id'); // Extract customer IDs from the request
        $project->customers()->attach($customerIds);


        return $project->load('customers');
    }

    public function update($data, $project)
    {
        // Update the project fields
        $project->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        // Extract customer IDs from the request
        $customerIds = collect($data['customers'])->pluck('id')->toArray();

        // Sync the customer relationships (attach new ones, detach the missing ones)
        $project->customers()->sync($customerIds);

        return $project->load('customers.addresses');
    }

    
    public function destroy($project)
    {
        $project->delete();
    }
}
