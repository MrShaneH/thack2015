using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HotelService
{
    public class MockedHotelService //: IHotelService
    {
        public HotelSearchResponse Search(HotelSearchRequest hotelSearchRequest)
        {
            var hotelSearchResponse = new HotelSearchResponse();
            hotelSearchResponse.HotelStays = new List<HotelStay>();
            hotelSearchResponse.HotelStays.Add(new HotelStay()
            {
                HotelId = 12345,
                Latitude = "Munich City Center",
                Longitude = "-5.10000000",
                LocationName = "64.10000000",
                Price = 99.99M
            });
            hotelSearchResponse.HotelStays.Add(new HotelStay()
            {
                HotelId = 545354,
                Latitude = "Manchester Palace",
                Longitude = "-6.10000000",
                LocationName = "66.10000000",
                Price = 20.00M
            });

            return hotelSearchResponse;
        }
    }
}
