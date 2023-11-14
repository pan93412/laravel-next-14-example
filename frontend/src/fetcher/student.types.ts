import z from "zod";

export type StudentActions = z.infer<typeof StudentSchema>;
export const StudentSchema = z.object({
  name: z.string(),
  addr: z.string(),
  birth: z.string().pipe(z.coerce.date()),
});

export type Students = z.infer<typeof StudentsSchema>;
export const StudentsSchema = z.array(StudentSchema);

export type StudentRequestDto = {
  name: string;
  addr: string;
  birth: string;
};
