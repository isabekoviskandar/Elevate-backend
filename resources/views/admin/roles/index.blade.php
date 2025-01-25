<div>
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title text-primary m-0">Roles</h5>

                    <button class="btn btn-primary btn-round ms-auto"
                        wire:click="$set('showForm', {{ $showForm ? 'false' : 'true' }})">
                        <i class="fa fa-plus me-1"></i>
                        {{ $showForm ? 'Back to list' : 'Create role' }}
                    </button>
                </div>

                <div class="card-body">
                    @if ($showForm)
                        <div>
                            <h5>{{ $editForm ? 'Edit role' : 'Create role' }}</h5>
                            <form wire:submit.prevent="submit">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" wire:model="name" class="form-control"
                                        placeholder="Enter the role name..">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success btn-round">Save</button>
                                    <button type="button" class="btn btn-secondary btn-round"
                                        wire:click="resetForm">Back</button>
                                </div>
                            </form>
                        </div>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Activity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked_{{ $role->id }}"
                                                    name="is_active_{{ $role->id }}" value="1"
                                                    {{ $role->is_active ? 'checked' : '' }}
                                                    wire:click="updateStatus({{ $role->id }}, $event.target.checked)">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckChecked_{{ $role->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-button-action d-flex align-items-center" style="gap: 4px;">
                                                <button wire:click.prevent="edit({{ $role->id }})" type="button"
                                                    class="btn btn-sm btn-primary" title="Edit role">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <button wire:click="prepareDelete({{ $role->id }})"
                                                    class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>


                                        <!-- Delete Confirmation Modal -->
                                        <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1"
                                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confitm to delete
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure to delete this role?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Back</button>
                                                        <button type="button" class="btn btn-danger"
                                                            wire:click="deleteConfirmed" data-bs-dismiss="modal">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
