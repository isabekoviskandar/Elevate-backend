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
                    <h5 class="card-title text-primary m-0">Users</h5>

                    <button class="btn btn-primary btn-round ms-auto"
                        wire:click="$set('createForm', {{ $createForm ? 'false' : 'true' }})">
                        <i class="fa fa-plus me-1"></i>
                        {{ $createForm ? 'Back to list' : 'Create User' }}
                    </button>
                </div>

                <div class="card-body">
                    @if ($createForm)
                        <div>
                            <h5>{{ $editForm ? 'Edit User' : 'Create User' }}</h5>
                            <form wire:submit.prevent="submit">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" wire:model="name" class="form-control"
                                        placeholder="Enter user name...">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mt-2">
                                    <label>Email</label>
                                    <input type="email" wire:model="email" class="form-control"
                                        placeholder="Enter user email...">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mt-2">
                                    <label>Password</label>
                                    <input type="password" wire:model="password" class="form-control"
                                        placeholder="Enter user password...">
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mt-2">
                                    <label>Role</label>
                                    <select wire:model="role_id" class="form-control">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>
                                            <div class="form-button-action d-flex align-items-center" style="gap: 4px;">
                                                <button wire:click.prevent="edit({{ $user->id }})" type="button"
                                                    class="btn btn-sm btn-primary" title="Edit User">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <button wire:click="prepareDelete({{ $user->id }})"
                                                    class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm to delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteConfirmed"
                        data-bs-dismiss="modal">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
