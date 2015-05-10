using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Dynamic;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;
using System.Web.Helpers;

namespace HotelService
{
    public class HotelBedsHotelService : IHotelService
    {
        public HotelSearchResponse Search(HotelSearchRequest hotelSearchRequest)
        {
            var url = "http://api.hotelbeds.com/hotel-api/1.0/availability";
            var json = getJson(hotelSearchRequest);

            var hotelSearchResponse = new HotelSearchResponse();
            hotelSearchResponse.HotelStays = new List<HotelStay>();

            using (var client = new WebClient())
            {
                client.Headers.Add("Content-Type", "application/json");
                client.Headers.Add("Api-Key", "6262k3bddqe67jsbahb9wqnx");

                byte[] responsebytes = client.UploadData(url, "POST",
                System.Text.Encoding.ASCII.GetBytes(json) );
                string jsonresponse = Encoding.UTF8.GetString(responsebytes);

                var data = JsonConvert.DeserializeObject<dynamic>(jsonresponse);

                foreach (var hotel in data.hotels.hotels)
                {
                    hotelSearchResponse.HotelStays.Add(new HotelStay()
                    {
                        HotelId = Convert.ToInt32(hotel.code),
                        Latitude = hotel.latitude,
                        Longitude = hotel.longitude,
                        Price = hotel.minPrice,
                        LocationName = hotel.destination
                    });
                }
            }

            return hotelSearchResponse;
        }

        private string getJson(HotelSearchRequest hotelSearchRequest)
        {
            var json = @"
                {
                ""stay"": {
                    ""checkIn"": """ + hotelSearchRequest.StartDate.ToString("yyyy-MM-dd ") + @""",
                    ""checkOut"": """ + hotelSearchRequest.StartDate.AddDays(1).ToString("yyyy-MM-dd").ToString() + @"""
                },
                ""occupancies"": [
                    {
                        ""rooms"": 1,
                        ""adults"": 2,
                        ""children"": 0,
                        ""paxes"": [
                            {
                                ""type"": ""AD"",
                                ""age"": 30
                            },
                            {
                                ""type"": ""AD"",
                                ""age"": 30
                            }
                        ]
                    }
                ],
                ""geolocation"": {
                    ""latitude"": """ + hotelSearchRequest.Latitude + @""",
                    ""longitude"": """ + hotelSearchRequest.Longitude + @""",
                    ""radius"": " + hotelSearchRequest.Radius + @",
                    ""unit"": ""km""
                },
                ""limit"": {
                    ""maxHotels"": 100
                }
            }";

            return json;
            
        }
    }
}
