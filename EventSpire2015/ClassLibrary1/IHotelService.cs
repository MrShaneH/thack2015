using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HotelService
{
    public interface IHotelService
    {
        Task<HotelSearchResponse> Search(HotelSearchRequest hotelSearchRequest);
    }
}
