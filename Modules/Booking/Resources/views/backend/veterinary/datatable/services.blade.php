<div style="width: 25%;">
  @if(count($data->services) > 1)
    <a class="badge bg-info text-white" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#service-detail-modal-{{ $data->id }}">Multiple</a>

    <!-- Modal -->
    <div class="modal fade" id="service-detail-modal-{{ $data->id }}" tabindex="-1" aria-labelledby="service-detail-modal-{{ $data->id }}-Label" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="service-detail-modal-{{ $data->id }}-Label">Service Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered m-0">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Service Name</th>
                  <th>Price</th>
                  <th>Duration (Min)</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data->services as $key => $service)
                  <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $service->service_name }}</td>
                    <td>{{ Currency::format($service->service_price ?? 0) }}</td>
                    <td>{{ $service->duration_min }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  @else
    <small class="badge bg-primary">{{ $data->services->first()->service_name ?? '-' }}</small>
  @endif
</div>
