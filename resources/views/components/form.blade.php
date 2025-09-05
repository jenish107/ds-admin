@if (session('message'))
    <h2 class="text-success">{{ session('message') }}</h2>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <form class="form-horizontal" action="{{ route($routeName) }}" method="POST">
                @csrf
                @if ($obj)
                    @method('PUT')
                @endif
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mt-2 ms-2">
                        @if ($obj)
                            Update {{ $name }}
                        @else
                            Add {{ $name }}
                        @endif
                    </h2>
                    <div class="pe-3">
                        <button type="button" class="btn btn-info" onclick="history.back();">
                            Back
                        </button>
                    </div>
                </div>

                <div class="card-body pt-2">
                    <div class="form-group row mt-2">
                        <label for="name" class="col-md-3">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Name Here" value="{{ $obj->name ?? '' }}" />
                            @error('name')
                                <div>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $obj->email ?? '' }}" name="email"
                                id="email" placeholder="email " />
                            @error('email')
                                <div>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    @if ($parentId)
                        <input type="hidden" value="{{ $parentId ?? '' }}" name="parentId" />
                    @endif
                    <input type="hidden" value="{{ $obj->id ?? '' }}" name="id" />
                </div>
                <div class="border-top">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">
                            @if ($obj)
                                Update
                            @else
                                Add
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
